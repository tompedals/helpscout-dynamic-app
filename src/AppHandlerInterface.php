<?php

namespace TomPedals\HelpScoutApp;

interface AppHandlerInterface
{
    public function handle(AppRequest $appRequest);
}
