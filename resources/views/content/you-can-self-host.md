---
title: You can self host
publication_date: "2024-11-30"
tags:
    - self-host
slug: you-can-self-host
summary: "Do you own an old PC? Maybe an unsued Raspberry Pi, you could try self-hosting."
---

I bought a Raspberry PI 4 over a year ago and left it unused for many months. Before trying to sell it I though I should _actually_ use it, a thus I fell into the rabbit whole of self hosting. Many of the software may have a self-hosted alternative or they may me designed for self-hosting out of the gate.

-   Netflix -> [Jellyfin](https://jellyfin.org/).
-   Bitwarden -> [Bitwarden](https://bitwarden.com/help/self-host-an-organization/) or [Vaultwarden](https://github.com/dani-garcia/vaultwarden).
-   Google Photos -> [Immich](https://immich.app/).
-   Audiobooks -> [Audio Book Shelf](https://www.audiobookshelf.org/).
-   Kindle -> [Calibre](https://github.com/janeczku/calibre-web).

Even this blog is hosted on my Raspberry PI! Besides, having an offline repository of media is pretty cool. Maybe a show you are watching is not available on Netflix, or you would like to safe guard it in case it could ever be removed from your streaming platform.

There are many challenges, yes, like availability and data back-up, but these sort of projects really open up your mind to the work online software does for you under the hood.

# How do I get started?

I first got my feet wet with [Yunohost](https://yunohost.org/), think of it as a managed layer above your OS. If then moved on into a more self-managed solution with [Portainer](https://www.portainer.io/) since I'm already familiar with Docker. Either way, I recommend you start small, a build up your own private cloud.
