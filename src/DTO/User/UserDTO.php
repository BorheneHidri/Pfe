<?php


namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UserCreateDTO
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 6)]
    public string $password;

    #[Assert\NotBlank]
    public string $fullname;

    public function __construct(string $email, string $password, string $fullname)
    {
        $this->email = $email;
        $this->password = $password;
        $this->fullname = $fullname;
    }
}
