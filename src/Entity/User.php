<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @Constraints\UniqueEntity(
 *     "email",
 *      message = "The email '{{ value }}' is already used, please choose another one."
 * )
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=2,
     *     max=255,
     *     minMessage="Your username must be at least {{ limit }} characters long",
     *     maxMessage="Your first name cannot be longer than {{ limit }} characters"
     *     )
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private string $password;

    /**
     * @ORM\OneToMany(targetEntity=Lexicon::class, mappedBy="user", orphanRemoval=true)
     */
    private Collection $lexicons;

    public function __construct()
    {
        $this->lexicons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Collection|Lexicon[]
     */
    public function getLexicons(): Collection
    {
        return $this->lexicons;
    }

    public function addLexicon(Lexicon $lexicon): self
    {
        if (!$this->lexicons->contains($lexicon)) {
            $this->lexicons[] = $lexicon;
            $lexicon->setUser($this);
        }

        return $this;
    }

    public function removeLexicon(Lexicon $lexicon): self
    {
        $this->lexicons->removeElement($lexicon);

        return $this;
    }
}
