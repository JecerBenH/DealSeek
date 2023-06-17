<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RatingRepository::class)
 */
class Rating
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Deal", inversedBy="id")
     * @ORM\JoinColumn(name="iddeal", referencedColumnName="id")
     * @ORM\Column(type="integer")
     */
    private $iddeal;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="id")
     * @ORM\JoinColumn(name="idu", referencedColumnName="email")
     * @ORM\Column(type="string")
     */
    private $idu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIddeal()
    {
        return $this->iddeal;
    }

    /**
     * @param mixed $iddeal
     */
    public function setIddeal($iddeal): void
    {
        $this->iddeal = $iddeal;
    }



    /**
     * @return mixed
     */
    public function getIdu()
    {
        return $this->idu;
    }

    /**
     * @param mixed $idu
     */
    public function setIdu($idu): void
    {
        $this->idu = $idu;
    }




}
