<?php

namespace Alura\BuscadorDeCurso;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    private ClientInterface $httpclient;
    private Crawler $crawler;
    public function __construct(ClientInterface $httpclient, Crawler $crawler)
    {
        $this->httpclient = $httpclient;
        $this->crawler = $crawler;
    }

    public function buscar($url): array
    {
        $reponse = $this->httpclient->request('GET', $url);
        $html = $reponse->getBody();
        $this->crawler->addHtmlContent($html);

        $elementosCursos = $this->crawler->filter('span.card-curso__nome');
        $cursos = [];
        foreach ($elementosCursos as $elementos) {
            $cursos[] = $elementos->textContent;
        }

        return $cursos;
    }
}
