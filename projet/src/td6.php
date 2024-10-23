<?php
declare(strict_types=1);

//require_once __DIR__ . '/classes/loader/Loader.php';
//use iutnc\deefy\loader\Loader;
//
//$loader = new Loader("iutnc\\deefy", __DIR__."/classes");
//$loader->register();

require __DIR__ . '/../vendor/autoload.php';


use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\audio\lists\Album;
use iutnc\deefy\renderer\Renderer;
use iutnc\deefy\renderer\RendererFactory;


$track1 = new AlbumTrack('track 1', '/', 'album1', 1);
$track1->genre = 18;

$track2 = new AlbumTrack('track 2', '/', 'album2', 2);
$track2->genre = 52;

$podcastTrack = new PodcastTrack('podcast ', 'test', 'test', 0, 0, 'test');

//print_r($track1);
//var_dump($track1);
//echo $track1 . "\n";
//print $track1 . "\n";
//printf("[%s]\n", $track1);

$renderer1 = RendererFactory::getRenderer($track1);
$renderer2 = RendererFactory::getRenderer($track2);
$renderer3 = RendererFactory::getRenderer($podcastTrack);

$album1 = new Album('titre album', [$track1, $track2]);

$playlist = new Playlist('titre playlist', [$track1, $track2]);
$playlist->addTrack($podcastTrack);

$albumrenderer = RendererFactory::getRenderer($album1);
echo $albumrenderer->render(Renderer::LONG);

$playlistrenderer = RendererFactory::getRenderer($playlist);
echo $playlistrenderer->render(Renderer::LONG);

$playlist->addTrack($podcastTrack);
$playlist->removeTrack(1);

echo $playlistrenderer->render(Renderer::LONG);
