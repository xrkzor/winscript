<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FieldRepository")
 */
class Field
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fieldName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $query;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $render;

    /**
     * @ORM\Column(type="integer")
     */
    private $placeholders;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Version", inversedBy="fields")
     * @ORM\JoinColumn(nullable=false)
     */
    private $version;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    public function getId()
    {
        return $this->id;
    }

    public function getFieldName(): ?string
    {
        return $this->fieldName;
    }

    public function setFieldName(string $fieldName): self
    {
        $this->fieldName = $fieldName;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function setQuery(string $query): self
    {
        $this->query = $query;

        return $this;
    }

    public function getRender(): ?string
    {
        return $this->render;
    }

    public function setRender(string $render): self
    {
        $this->render = $render;

        return $this;
    }

    public function getPlaceholders(): ?int
    {
        return $this->placeholders;
    }

    public function setPlaceholders(int $placeholders): self
    {
        $this->placeholders = $placeholders;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
