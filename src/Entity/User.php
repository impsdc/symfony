<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /** * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Votre nom doit étre constitué d'au moins {{ limit }} characters",
     *      maxMessage = "Votre nom ne peux pas avoir plus de {{ limit }} characters"
     * )
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Votre nom doit étre constitué d'au moins {{ limit }} characters",
     *      maxMessage = "Votre nom ne peux pas avoir plus de {{ limit }} characters"
     * )
     * @ORM\Column(type="string")
     */
    private $prenom;

    /**
     
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas un email valide."
     * )
     */
    private $email;

    /**
    * @ORM\Column(name="date", type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tache", inversedBy="users")
     */
    private $tache;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getDate($format = 'Y-m-d H:i:s')
    {
        return $this->date->format($format);
    }

    public function setDate($date)
    {
        $this->date = $date;
 
        $day   = $date->format('d'); // Format the current date, take the current day (01 to 31)
        $month = $date->format('m'); // Same with the month
        $year  = $date->format('Y'); // Same with the year
     
        $date = $day.'-'.$month.'-'.$year; // Return a string and not an object
     
        return $date;
    }

    public function __toString(){
        return $this->getName();
    }

    public function getTache(): ?Tache
    {
        return $this->tache;
    }

    public function setTache(?Tache $tache): self
    {
        $this->tache = $tache;

        return $this;
    }
}
