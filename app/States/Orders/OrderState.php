<?php

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;
use States\CompletedState;
use States\InProgressState;
use States\PendingState;

abstract class OrderState extends State
{
    /**
     * @throws \Spatie\ModelStates\Exceptions\InvalidConfig
     */
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(\States\PendingState::class)
            ->allowTransition(PendingState::class, InProgressState::class)
            ->allowTransition(InProgressState::class, CompletedState::class);
    }
}
