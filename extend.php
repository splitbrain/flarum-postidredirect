<?php



use Flarum\Extend;
use splitbrain\postidredirector\Redirector;

return [
    (new Extend\Routes('forum'))
        ->get('/post/{id:[\d\S]+(?:-[^/]*)?}', 'splitbrain.postidredirector', Redirector::class),
];
