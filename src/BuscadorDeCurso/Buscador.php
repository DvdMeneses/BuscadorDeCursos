<?php

namespace Dvdmeneses\BuscadorDeCurso;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var Crawler
     */
    private $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    public function buscar(string $url): array
    {
        $resposta = $this->httpClient->request('GET', $url);
        $html = $resposta->getBody()->getContents();
        $this->crawler->addHtmlContent($html);
        $ElementosCursos = $this->crawler->filter('span.card-curso__nome');
        $cursos = [];
        foreach ($ElementosCursos as $elemento) {
            $cursos[] = $elemento->textContent;
        }
        return $cursos;
    }
}
