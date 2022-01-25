<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Lexicon::class, mappedBy="user", orphanRemoval=true)
     */
    private $lexicons;

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
     * @return Collection|Lexicon[]
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
        if ($this->lexicons->removeElement($lexicon)) {
            // set the owning side to null (unless already changed)
            if ($lexicon->getUser() === $this) {
                $lexicon->setUser(null);
            }
        }

        return $this;
    }
}
