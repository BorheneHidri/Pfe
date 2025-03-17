<?php
namespace App\DTO\Member;

class MemberDTO
{
    public string $name;
    public string $avatar;

    public function __construct(string $name = '', string $avatar = '')
    {
        $this->name = $name;
        $this->avatar = $avatar;
    }
}
