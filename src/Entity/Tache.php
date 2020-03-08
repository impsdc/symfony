<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TacheRepository")
 */
class Tache
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(
     *      min = 5,
     *      max = 255,
     *      minMessage = "Votre Tache doit étre constitué d'au moins {{ limit }} characters",
     *      maxMessage = "Votre Tache est trop longue"
     * )
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(name="deadline", type="datetime")
     */
    private $deadline;

    /**
     * @Assert\NotNull
     * @ORM\Column(type="boolean")
     */
    private $faite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="taches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;


    public function __construct()
    {
        $this->taches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDeadline()
    {
        return $this->deadline;
    }

    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
 
        $day   = $deadline->format('d'); // Format the current date, take the current day (01 to 31)
        $month = $deadline->format('m'); // Same with the month
        $year  = $deadline->format('Y'); // Same with the year
     
        $deadline = $day.'-'.$month.'-'.$year; // Return a string and not an object
     
        return $deadline;
    }

    public function getFaite(): ?bool
    {
        return $this->faite;
    }

    public function setFaite(bool $faite): self
    {
        $this->faite = $faite;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function __toString(){
        return $this->getName();
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setTache($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getTache() === $this) {
                $user->setTache(null);
            }
        }

        return $this;
    }       
}