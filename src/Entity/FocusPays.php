<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FocusPaysRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=FocusPaysRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *  fields={"title"},
 *  message="Un Focus Pays possède déjà ce titre"
 * )
 */
class FocusPays
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3, max=255, minMessage="Le titre doit faire plus de 10 caractères !", maxMessage="Le titre ne peut pas faire plus de 255 caractères !")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $introduction;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=20, max=255, minMessage="L'introduction doit faire plus de 20 caractères !", maxMessage="L'introduction ne peut pas faire plus de 255 caractères !")
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageCover;

    /**
     * @ORM\OneToMany(targetEntity=FocusVille::class, mappedBy="focusPays", orphanRemoval=true)
     */
    private $focusVilles;

    /**
     * @ORM\OneToOne(targetEntity=MarkerPays::class, mappedBy="focusPays", cascade={"persist", "remove"})
     */
    private $markerPays;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="focusPays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

      /**
     * Permet d'initialiser le slug
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * 
     * @return void
     */
    public function initializeSlug() {
        if(empty($this->slug)){
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->title);
        }
    }


    public function __construct()
    {
        $this->focusVilles = new ArrayCollection();
    }

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

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

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

    public function getImageCover(): ?string
    {
        return $this->imageCover;
    }

    public function setImageCover(string $imageCover): self
    {
        $this->imageCover = $imageCover;

        return $this;
    }

    /**
     * @return Collection|FocusVille[]
     */
    public function getFocusVilles(): Collection
    {
        return $this->focusVilles;
    }

    public function addFocusVille(FocusVille $focusVille): self
    {
        if (!$this->focusVilles->contains($focusVille)) {
            $this->focusVilles[] = $focusVille;
            $focusVille->setFocusPays($this);
        }

        return $this;
    }

    public function removeFocusVille(FocusVille $focusVille): self
    {
        if ($this->focusVilles->contains($focusVille)) {
            $this->focusVilles->removeElement($focusVille);
            // set the owning side to null (unless already changed)
            if ($focusVille->getFocusPays() === $this) {
                $focusVille->setFocusPays(null);
            }
        }

        return $this;
    }

    public function getMarkerPays(): ?MarkerPays
    {
        return $this->markerPays;
    }

    public function setMarkerPays(MarkerPays $markerPays): self
    {
        $this->markerPays = $markerPays;

        // set the owning side of the relation if necessary
        if ($markerPays->getFocusPays() !== $this) {
            $markerPays->setFocusPays($this);
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
