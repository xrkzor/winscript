<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository") 
 * @UniqueEntity(
 * fields={"username"},
 * message="Ce nom d'utilisateur existe déjà !"
 * )
 */

class Utilisateur implements UserInterface 
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Votre mot de passe doit faire au minimum 8 caractères !"
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $radio;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Version", inversedBy="utilisateurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $version;
    /**
     * @Assert\EqualTo(propertyPath="password", message="Les deux mots de passe ne sont pas identiques !")
     */
    public $confirm_password;
    

    public function getId()
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRadio(): ?string
    {
        return $this->radio;
    }

    public function setRadio(string $radio): self
    {
        $this->radio = $radio;

        return $this;
    }

    public function getVersion(): ?Version
    {
        return $this->version;
    }

    public function setVersion(?Version $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function eraseCredentials(){

    }

    public function getSalt(){

    }

    public function getRoles() {
        return ['ROLE_USER'];
    }
}
