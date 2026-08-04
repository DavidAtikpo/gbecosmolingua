#!/usr/bin/env python3
"""Génère les images placeholder du hub Paremiologie."""

from __future__ import annotations

import math
import random
from pathlib import Path

from PIL import Image, ImageDraw, ImageFilter

OUT = Path(__file__).resolve().parents[1] / "themes/gbecosmolingua/assets/images/paremiologie"
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


def gradient(size: tuple[int, int], c1, c2) -> Image.Image:
    w, h = size
    img = Image.new("RGB", size)
    px = img.load()
    for y in range(h):
        for x in range(w):
            t = (x + y) / (w + h)
            px[x, y] = (lerp(c1[0], c2[0], t), lerp(c1[1], c2[1], t), lerp(c1[2], c2[2], t))
    return img


def add_quotes(img: Image.Image) -> None:
    draw = ImageDraw.Draw(img, "RGBA")
    w, h = img.size
    rng = random.Random(7)
    for _ in range(6):
        x, y = rng.randint(20, w - 20), rng.randint(20, h - 20)
        draw.text((x, y), "\u201c", fill=(255, 250, 240, 90))
    for y in range(0, h, 18):
        draw.line([(20, y), (w - 20, y + int(4 * math.sin(y / 12)))], fill=(255, 250, 240, 35), width=1)


def save(name: str, size: tuple[int, int], c1, c2, pattern: bool = False) -> None:
    img = gradient(size, c1, c2)
    if pattern:
        add_quotes(img)
    img = img.filter(ImageFilter.GaussianBlur(radius=0.25))
    img.save(OUT / name, "JPEG", quality=88, optimize=True)
    print(f"  {name}")


def main() -> None:
    print(f"Generating Paremiologie images in {OUT}")
    save("hero-proverbes.jpg", (1600, 900), PALETTE["bark"], PALETTE["gold"], True)
    save("section-banque.jpg", (800, 560), PALETTE["gold"], PALETTE["green"], True)
    save("section-corpus.jpg", (800, 560), PALETTE["green_mid"], PALETTE["green"], True)
    save("section-comparaisons.jpg", (800, 560), PALETTE["sand"], PALETTE["bark"], True)
    save("section-axes.jpg", (800, 560), PALETTE["green"], PALETTE["bark"], True)
    save("corpus-ewe.jpg", (480, 360), PALETTE["green"], PALETTE["gold"], True)
    save("corpus-gen.jpg", (480, 360), PALETTE["green_mid"], PALETTE["sand"], True)
    save("corpus-fon.jpg", (480, 360), PALETTE["bark"], PALETTE["gold"], True)
    save("corpus-aja.jpg", (480, 360), (107, 83, 68), PALETTE["bark"], True)
    save("corpus-gun.jpg", (480, 360), (47, 104, 64), PALETTE["green"], True)
    print("Done.")


if __name__ == "__main__":
    main()
