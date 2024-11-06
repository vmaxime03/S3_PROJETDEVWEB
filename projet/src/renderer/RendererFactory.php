<?php

namespace iutnc\deefy\renderer;

use iutnc\deefy\audio\tracks\audioTrack;
use iutnc\deefy\audio\lists\Album;
use iutnc\deefy\audio\lists\AudioList;
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\dbclasses\User;
use iutnc\deefy\renderer\AlbumTrackRenderer;
use iutnc\deefy\renderer\AudioListRenderer;
use iutnc\deefy\renderer\PodcastTrackRenderer;
use iutnc\deefy\renderer\Renderer;
use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;

class RendererFactory
{
    public static function getRenderer(AudioTrack|AudioList|User $toRender) : Renderer {
        return match (get_class($toRender)) {
            AlbumTrack::class => new AlbumTrackRenderer($toRender),
            PodcastTrack::class => new PodcastTrackRenderer($toRender),
            Album::class => new AudioListRenderer($toRender),
            Playlist::class => new AudioListRenderer($toRender),
            User::class => new UserRenderer($toRender),
            default => throw new \Exception("Unknown renderer"),
        };
    }
}