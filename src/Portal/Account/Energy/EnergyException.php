<?php

declare(strict_types=1);

namespace Portal\Account\Energy;

use Exception;

class EnergyException extends Exception
{
    public const ALREADY_MAX                  = 'Energy already max';
    public const NO_ENOUGH                    = 'No enough energy. Have %d need %d';
    public const ZERO_VALUE                   = 'No change energy: zero value';
    public const INCORRECT_ENERGY_ID_DATA     = 'EnergyFactory: Incorrect "energy_id" data, excepted string';
    public const INCORRECT_ENERGY_ID_VALUE    = 'EnergyFactory: Incorrect "energy_id", should be min-max length: ';
    public const INCORRECT_ACCOUNT_ID_DATA    = 'EnergyFactory: Incorrect "account_id" data, excepted string';
    public const INCORRECT_ACCOUNT_ID_VALUE   = 'EnergyFactory: Incorrect "account_id", should be min-max length: ';
    public const INCORRECT_ENERGY_DATA        = 'EnergyFactory: Incorrect "energy" data, excepted integer';
    public const INCORRECT_ENERGY_VALUE       = 'EnergyFactory: Incorrect "energy", should be min-max length: ';
    public const INCORRECT_ENERGY_BONUS_DATA  = 'EnergyFactory: Incorrect "energy_bonus" data, excepted integer';
    public const INCORRECT_ENERGY_BONUS_VALUE = 'EnergyFactory: Incorrect "energy_bonus", should be min-max length: ';
    public const INCORRECT_UPDATED_AT_DATA    = 'EnergyFactory: Incorrect "energy_updated_at" data, excepted integer or float';
    public const INCORRECT_RESIDUE_DATA       = 'EnergyFactory: Incorrect "energy_residue" data, excepted integer';
}