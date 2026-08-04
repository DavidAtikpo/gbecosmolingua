#!/usr/bin/env python3
"""Génère les images placeholder du hub Xótùtù."""

from __future__ import annotations

import math
import random
from pathlib import Path

from PIL import Image, ImageDraw, ImageFilter

OUT = Path(__file__).resolve().parents[1] / "themes/gbecosmolingua/assets/images/xotutu"
OUT.mkdir(parents=True, exist_ok=True)

PALETTE = {
    "green": (18, 56, 25),
    "green_mid": (31, 91, 42),
    "gold": (184, 121, 19),
    "sand": (247, 241, 223),
    "bark": (74, 37, 12),
}


def lerp(a: int, b: int, t: float) -> int:
    return int(a + (b - a) * t)


def gradient(size: tuple[int, int], c1: tuple[int, int, int], c2: tuple[int, int, int]) -> Image.Image:
    w, h = size
    img = Image.new("RGB", size)
    px = img.load()
    for y in range(h):
        for x in range(w):
            t = (x + y) / (w + h)
            px[x, y] = (lerp(c1[0], c2[0], t), lerp(c1[1], c2[1], t), lerp(c1[2], c2[2], t))
    return img


def add_pattern(img: Image.Image, kind: str) -> None:
    draw = ImageDraw.Draw(img, "RGBA")
    w, h = img.size
    rng = random.Random(hash(kind) & 0xFFFF)
    if kind == "oral":
        for _ in range(5):
            x, y = rng.randint(0, w), rng.randint(0, h)
            draw.ellipse((x - 40, y - 40, x + 40, y + 40), outline=(255, 250, 240, 70), width=3)
    elif kind == "audio":
        for y in range(0, h, 14):
            pts = [(x, y + int(10 * math.sin(x / 18))) for x in range(0, w, 10)]
            if len(pts) > 1:
                draw.line(pts, fill=(255, 250, 240, 60), width=2)
    elif kind == "book":
        for _ in range(4):
            x, y = rng.randint(0, w - 50), rng.randint(0, h - 70)
            draw.rectangle((x, y, x + 40, y + 60), outline=(247, 241, 223, 80), width=2)


def save(name: str, size: tuple[int, int], c1, c2, pattern: str = "") -> None:
    img = gradient(size, c1, c2)
    if pattern:
        add_pattern(img, pattern)
    img = img.filter(ImageFilter.GaussianBlur(radius=0.3))
    img.save(OUT / name, "JPEG", quality=88, optimize=True)
    print(f"  {name}")


def main() -> None:
    print(f"Generating Xótùtù images in {OUT}")
    save("hero-orality.jpg", (1600, 900), PALETTE["bark"], PALETTE["green_mid"], "oral")
    save("collection-oral.jpg", (480, 360), PALETTE["green_mid"], PALETTE["green"], "oral")
    save("collection-chants.jpg", (480, 360), PALETTE["gold"], PALETTE["bark"], "audio")
    save("collection-audio.jpg", (480, 360), PALETTE["green"], PALETTE["green_mid"], "audio")
    save("collection-video.jpg", (480, 360), (35, 21, 12), PALETTE["green_mid"], "book")
    save("collection-photo.jpg", (480, 360), PALETTE["sand"], PALETTE["gold"], "book")
    save("collection-docs.jpg", (480, 360), PALETTE["green_mid"], (13, 40, 24), "book")
    print("Done.")


if __name__ == "__main__":
    main()
