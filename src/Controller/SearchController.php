<?php

// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// Import TNTSearch
use TeamTNT\TNTSearch\TNTSearch;
use TeamTNT\TNTSearch\Stemmer\FrenchStemmer;
use App\Entity\Word;

class SearchController extends AbstractController
{
    private function getTNTSearchConfiguration(): array
    {
        $databaseURL = $_ENV['DATABASE_URL'];

        $databaseParameters = parse_url($databaseURL);

        $config = [
            'driver' => $databaseParameters["scheme"],
            'host' => $databaseParameters["host"],
            'database' => str_replace("/", "", $databaseParameters["path"]),
            'username' => $databaseParameters["user"],
            'password' => $databaseParameters["pass"],
            // Create the fuzzy_storage directory in your project to store the index file
            'storage' => __DIR__ . '/../../fuzzy_storage/',
            // A stemmer is optional
            'stemmer' => FrenchStemmer::class,
        ];

        return $config;
    }

    /**
     * @Route("/generate-index", name="app_generate-index")
     */
    public function generateIndex(): Response
    {
        $tnt = new TNTSearch();

        // Obtain and load the configuration that can be generated with the previous described method
        $configuration = $this->getTNTSearchConfiguration();
        $tnt->loadConfig($configuration);

        // The index file will have the following name, feel free to change it as you want
        $indexer = $tnt->createIndex('words');

        // The result with all the rows of the query will be the data
        // that the engine will use to search, in our case we only want one column (name)
        // (note that the primary key needs to be included)
        $indexer->query('SELECT id, name FROM word;');

        // Generate index file !
        $indexer->run();

        return new Response(
            '<html><body>Index succesfully generated !</body></html>'
        );
    }

    /**
     * @Route("/search", name="app_search", methods={"GET"})
     */
    public function search(Request $request): Response
    {
        $docManager = $this->getDoctrine()->getManager();

        $tnt = new TNTSearch();
        $tnt->asYouType = true;

        // Obtain and load the configuration that can be generated with the previous described method
        $configuration = $this->getTNTSearchConfiguration();
        $tnt->loadConfig($configuration);

        // Use the generated index in the previous step
        $tnt->selectIndex('words');

        $maxResults = 20;

        // Search for the terms in method GET inside $research
        $research = $request->query->get('terms');
        $results = $tnt->search($research, $maxResults);

        // Keep a reference to the Doctrine repository of words
        $wordsRepository = $docManager->getRepository(Word::class);

        // Store the results in an array
        $rows = [];

        foreach ($results["ids"] as $id) {
                // You can optimize this by using the FIELD function of MySQL if you are using mysql
                // more info at: https://ourcodeworld.com/articles/read/1162/how-to-order-a-doctrine-2-query-result-by-a-specific-order-of-an-array-using-mysql-in-symfony-5
                $word = $wordsRepository->find($id);

                $rows[] = $word;
        }

        return $this->render('search/results.html.twig', ['rows' => $rows]);
    }
}
