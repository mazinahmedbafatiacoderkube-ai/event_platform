<?php

namespace App\Services;

use App\DTO\RegisterOrganizationDTO;
use App\DTO\LoginUserDTO;
use App\Actions\CreateOrganizationAction;
use App\Actions\CreateOwnerUserAction;
use App\Actions\LoginUserAction;

class AuthService
{
    protected $createOrganizationAction;
    protected $createOwnerUserAction;
    protected $loginUserAction;

    public function __construct(
        CreateOrganizationAction $createOrganizationAction,
        CreateOwnerUserAction $createOwnerUserAction,
        LoginUserAction $loginUserAction
    ){
        $this->createOrganizationAction = $createOrganizationAction;
        $this->createOwnerUserAction = $createOwnerUserAction;
        $this->loginUserAction = $loginUserAction;
    }

    public function registerOrganization(RegisterOrganizationDTO $dto)
    {
        $organization = $this->createOrganizationAction->execute($dto);

        return $this->createOwnerUserAction->execute($dto, $organization->id);
    }

    public function login(LoginUserDTO $dto)
    {
        // delegate authentication to action
        $this->loginUserAction->execute($dto);

        return true;
    }
}