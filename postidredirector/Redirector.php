<?php


namespace splitbrain\postidredirector;

use Flarum\Frontend\Document;
use Flarum\Http\Exception\RouteNotFoundException;
use Flarum\Http\UrlGenerator;
use Flarum\Post\Post;
use Illuminate\Support\Arr;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Redirector implements RequestHandlerInterface
{
    /**
     * @var UrlGenerator
     */
    protected $urlGenerator;

    /**
     * @param UrlGenerator $url
     */
    public function __construct(UrlGenerator $url)
    {
        $this->urlGenerator = $url;
    }


    /**
     * @inheritdoc
     * @throws RouteNotFoundException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = Arr::get($request->getQueryParams(), 'id');
        $post = Post::find($id);

        if ($post) {
            return new RedirectResponse(
                $this->urlGenerator->to('forum')->route(
                    'discussion',
                    [
                        'id' => $post->discussion_id,
                        'near' => $post->number
                    ]
                )
            );
        }

        throw new RouteNotFoundException();
    }
}
