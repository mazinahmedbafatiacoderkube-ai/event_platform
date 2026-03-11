<?php

namespace App\DTO;

class RegisterOrganizationDTO
{
    public string $organizationName;
    public string $plan;
    public string $ownerName;
    public string $ownerEmail;
    public string $password;

    public function __construct(
        string $organizationName,
        string $plan,
        string $ownerName,
        string $ownerEmail,
        string $password
    ) {
        $this->organizationName = $organizationName;
        $this->plan = $plan;
        $this->ownerName = $ownerName;
        $this->ownerEmail = $ownerEmail;
        $this->password = $password;
    }
}