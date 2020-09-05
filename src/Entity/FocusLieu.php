<?php

namespace App\Entity;

use App\Repository\FocusLieuRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=FocusLieuRepository::class)
 */
class FocusLieu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=10, max=255, minMessage="Le titre doit faire plus de 10 caractères !", maxMessage="Le titre ne peut pas faire plus de 255 caractères !")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=50, minMessage="Le contenu doit faire plus de 50 caractères !")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=FocusVille::class, inversedBy="focusLieus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $focusVille;

    /**
     * @ORM\OneToOne(targetEntity=MarkerLieu::class, mappedBy="focusLieu", cascade={"persist", "remove"})
     */
    private $markerLieu;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getFocusVille(): ?FocusVille
    {
        return $this->focusVille;
    }

    public function setFocusVille(?FocusVille $focusVille): self
    {
        $this->focusVille = $focusVille;

        return $this;
    }

    public function getMarkerLieu(): ?MarkerLieu
    {
        return $this->markerLieu;
    }

    public function setMarkerLieu(MarkerLieu $markerLieu): self
    {
        $this->markerLieu = $markerLieu;

        // set the owning side of the relation if necessary
        if ($markerLieu->getFocusLieu() !== $this) {
            $markerLieu->setFocusLieu($this);
        }

        return $this;
    }
}
