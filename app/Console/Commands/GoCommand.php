<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Param\ParamFilterTypeEnum;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:go')]
#[Description('Command description')]
class GoCommand extends Command
{
    public function handle(): void
    {
        //        ParamFilterTypeEnum::options();
        //        dd(ParamFilterTypeEnum::options());
    }
}
