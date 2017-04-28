<?php

namespace sil16\VitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * Customer
 */
class Customer implements UserInterface, \Serializable
{

    public function getUsername() {
        return $this->email; // l'email est utilisé comme login
    }

    public function getSalt() {
        return null; // inutile avec l’encryptage choisi
    }

    public function getRoles() {
      if ($this->is_admin) // Si le client est administrateur
        return array('ROLE_ADMIN'); // on lui accorde le rôle ADMIN
      else
        return array('ROLE_CUSTOMER'); // sinon le rôle USER
    }

    public function eraseCredentials(){// rien à faire ici
    }

    public function serialize() { // pour pouvoir sérialiser le Client en session
        return serialize(array($this->id));
    }

    public function unserialize($serialized) {
        list ($this->id) = unserialize($serialized);
    }

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $commandes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commandes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Customer
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Customer
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Customer
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Add commandes
     *
     * @param \sil16\VitrineBundle\Entity\Commande $commandes
     * @return Customer
     */
    public function addCommande(\sil16\VitrineBundle\Entity\Commande $commandes)
    {
        $this->commandes[] = $commandes;

        return $this;
    }

    /**
     * Remove commandes
     *
     * @param \sil16\VitrineBundle\Entity\Commande $commandes
     */
    public function removeCommande(\sil16\VitrineBundle\Entity\Commande $commandes)
    {
        $this->commandes->removeElement($commandes);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandes()
    {
        return $this->commandes;
    }
    /**
     * @var boolean
     */
    private $is_admin;


    /**
     * Set is_admin
     *
     * @param boolean $isAdmin
     * @return Customer
     */
    public function setIsAdmin($isAdmin)
    {
        $this->is_admin = $isAdmin;

        return $this;
    }

    /**
     * Get is_admin
     *
     * @return boolean
     */
    public function getIsAdmin()
    {
        return $this->is_admin;
    }
}
