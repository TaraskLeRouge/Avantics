<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @ORM\Table(
 *      name="`users`",
 *      indexes={
 *          @ORM\Index(name="lastname_idx", columns={"lastname"}),
 *          @ORM\Index(name="firstname_idx", columns={"firstname"}),
 *          @ORM\Index(name="firstname_idx", columns={"gender"}),
 *          @ORM\Index(name="firstname_idx", columns={"birthdate"}),
 *          @ORM\Index(name="firstname_idx", columns={"post_code"}),
 *          @ORM\Index(name="firstname_idx", columns={"optin_date"}),
 *          @ORM\Index(name="firstname_idx", columns={"unsubscripe_date"}),
 *      },
 * )
 */
class Users
{
    const gender = ['male' => 'male', 'femelle' => 'femelle'];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "author.name.not_blank")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(name="gender", type="string", length=255, columnDefinition="enum('male', 'femelle')")
     * @Assert\Choice({"male", "femelle"}, message="Choose a valid gender.")
     */
    private $gender;

    /**
     * @ORM\Column(type="date")
     * @Assert\Type("datetime")
     * @Assert\LessThanOrEqual("-18 years", message="This value should be less than or equal to {{ value }}")
     *
     */
    private $birthdate;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(
     *      min = 5,
     *      max = 5,
     *      exactMessage = "This value should have exactly {{ limit }} characters.",
     *      allowEmptyString = false
     * )
     */
    private $post_code;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Choice({false,true}, message="Choose a valid gender.")
     */
    private $travel;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Choice({false,true}, message="Choose a valid gender.")
     */
    private $contest_game;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Choice({false,true}, message="Choose a valid gender.")
     */
    private $auto_moto;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Choice({false,true}, message="Choose a valid gender.")
     */
    private $shopping;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Choice({false,true}, message="Choose a valid gender.")
     */
    private $cosmetic;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Choice({false,true}, message="Choose a valid gender.")
     */
    private $insurance;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Choice({false,true}, message="Choose a valid gender.")
     */
    private $mutual_health;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\IsTrue(message="The optin is invalid.")
     */
    private $optin;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Type("datetime")
     * @var string A "Y-m-d H:i:s" formatted value
     */
    private $optin_date;

    /**
     * @ORM\Column(type="string", length=16)
     * @Assert\Ip
     */
    private $optin_ip;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime
     * @var string A "Y-m-d H:i:s" formatted value
     */
    private $unsubscripe_date;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     * @Assert\Ip
     */
    private $unsubscripe_ip;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getGender(): ?array
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getPostCode(): ?int
    {
        return $this->post_code;
    }

    public function setPostCode(int $post_code): self
    {
        $this->post_code = $post_code;

        return $this;
    }

    public function getTravel(): ?bool
    {
        return $this->travel;
    }

    public function setTravel(bool $travel): self
    {
        $this->travel = $travel;

        return $this;
    }

    public function getContestGame(): ?bool
    {
        return $this->contest_game;
    }

    public function setContestGame(bool $contest_game): self
    {
        $this->contest_game = $contest_game;

        return $this;
    }

    public function getAutoMoto(): ?bool
    {
        return $this->auto_moto;
    }

    public function setAutoMoto(bool $auto_moto): self
    {
        $this->auto_moto = $auto_moto;

        return $this;
    }

    public function getShopping(): ?bool
    {
        return $this->shopping;
    }

    public function setShopping(bool $shopping): self
    {
        $this->shopping = $shopping;

        return $this;
    }

    public function getCosmetic(): ?bool
    {
        return $this->cosmetic;
    }

    public function setCosmetic(bool $cosmetic): self
    {
        $this->cosmetic = $cosmetic;

        return $this;
    }

    public function getInsurance(): ?bool
    {
        return $this->insurance;
    }

    public function setInsurance(bool $insurance): self
    {
        $this->insurance = $insurance;

        return $this;
    }

    public function getMutualHealth(): ?bool
    {
        return $this->mutual_health;
    }

    public function setMutualHealth(bool $mutual_health): self
    {
        $this->mutual_health = $mutual_health;

        return $this;
    }

    public function getOptin(): ?bool
    {
        return $this->optin;
    }

    public function setOptin(bool $optin): self
    {
        $this->optin = $optin;

        return $this;
    }

    public function getOptinDate(): ?\DateTimeInterface
    {
        return $this->optin_date;
    }

    public function setOptinDate(\DateTimeInterface $optin_date): self
    {
        $this->optin_date = $optin_date;

        return $this;
    }

    public function getOptinIp(): ?string
    {
        return $this->optin_ip;
    }

    public function setOptinIp(string $optin_ip): self
    {
        $this->optin_ip = $optin_ip;

        return $this;
    }

    public function getUnsubscripeDate(): ?\DateTimeInterface
    {
        return $this->unsubscripe_date;
    }

    public function setUnsubscripeDate(\DateTimeInterface $unsubscripe_date): self
    {
        $this->unsubscripe_date = $unsubscripe_date;

        return $this;
    }

    public function getUnsubscripeIp(): ?string
    {
        return $this->unsubscripe_ip;
    }

    public function setUnsubscripeIp(?string $unsubscripe_ip): self
    {
        $this->unsubscripe_ip = $unsubscripe_ip;

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('optin', new Assert\IsTrue());
    }
}
