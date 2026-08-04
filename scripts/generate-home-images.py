#!/usr/bin/env python3
"""Génère les images placeholder de la page d'accueil GbeCosmoLingua."""

from __future__ import annotations

import math
import random
from pathlib import Path

from PIL import Image, ImageDraw, ImageFilter, ImageFont

OUT = Path(__file__).resolve().parents[1] / "themes/gbecosmolingua/assets/images/home"
OUT.mkdir(parents=True, exist_ok=True)

PALETTE = {
    "green": (18, 56, 25),
    "green_mid": (31, 91, 42),
    "gold": (184, 121, 19),
    "sand": (247, 241, 223),
    "bark": (74, 37, 12),
    "cream": (255, 250, 240),
}


def lerp(a: int, b: int, t: float) -> int:
    return int(a + (b - a) * t)


def gradient(size: tuple[int, int], c1: tuple[int, int, int], c2: tuple[int, int, int], angle: float = 0.0) -> Image.Image:
    w, h = size
    img = Image.new("RGB", size)
    px = img.load()
    rad = math.radians(angle)
    cos_a, sin_a = math.cos(rad), math.sin(rad)
    for y in range(h):
        for x in range(w):
            t = (x * cos_a + y * sin_a) / (w + h)
            t = max(0.0, min(1.0, t))
            px[x, y] = (lerp(c1[0], c2[0], t), lerp(c1[1], c2[1], t), lerp(c1[2], c2[2], t))
    return img


def add_noise(img: Image.Image, amount: int = 18) -> Image.Image:
    w, h = img.size
    overlay = Image.new("RGB", (w, h))
    opx = overlay.load()
    rng = random.Random(42)
    for y in range(h):
        for x in range(w):
            n = rng.randint(-amount, amount)
            opx[x, y] = (n, n, n)
    return Image.blend(img, overlay, 0.06)


def add_vignette(img: Image.Image) -> Image.Image:
    w, h = img.size
    mask = Image.new("L", (w, h), 0)
    draw = ImageDraw.Draw(mask)
    draw.ellipse((-w * 0.15, -h * 0.15, w * 1.15, h * 1.15), fill=255)
    mask = mask.filter(ImageFilter.GaussianBlur(radius=min(w, h) // 6))
    dark = Image.new("RGB", (w, h), PALETTE["bark"])
    return Image.composite(img, dark, Image.eval(mask, lambda p: 255 - p // 3))


def draw_pattern(img: Image.Image, kind: str) -> None:
    draw = ImageDraw.Draw(img, "RGBA")
    w, h = img.size
    rng = random.Random(hash(kind) & 0xFFFF)
    if kind == "drum":
        for i in range(6):
            cx, cy = rng.randint(0, w), rng.randint(0, h)
            r = rng.randint(20, 60)
            draw.ellipse((cx - r, cy - r, cx + r, cy + r), outline=(255, 250, 240, 80), width=3)
    elif kind == "book":
        for i in range(5):
            x = rng.randint(0, w - 40)
            y = rng.randint(0, h - 60)
            draw.rectangle((x, y, x + 35, y + 55), outline=(247, 241, 223, 90), width=2)
    elif kind == "wave":
        for y in range(0, h, 12):
            pts = [(x, y + int(8 * math.sin(x / 20 + y / 30))) for x in range(0, w, 8)]
            if len(pts) > 1:
                draw.line(pts, fill=(255, 250, 240, 60), width=2)
    elif kind == "map":
        for _ in range(8):
            x1, y1 = rng.randint(0, w), rng.randint(0, h)
            x2, y2 = rng.randint(0, w), rng.randint(0, h)
            draw.line((x1, y1, x2, y2), fill=(184, 121, 19, 70), width=2)


def save_card(name: str, size: tuple[int, int], c1: tuple[int, int, int], c2: tuple[int, int, int], pattern: str = "") -> None:
    img = gradient(size, c1, c2, angle=random.Random(name).__hash__() % 360 / 10)
    if pattern:
        draw_pattern(img, pattern)
    img = add_noise(img)
    img = add_vignette(img)
    img.save(OUT / name, "JPEG", quality=88, optimize=True)
    print(f"  {name}")


def main() -> None:
    print(f"Generating images in {OUT}")

    langs = [
        ("lang-ewe.jpg", PALETTE["green_mid"], PALETTE["green"], "drum"),
        ("lang-fon.jpg", PALETTE["bark"], PALETTE["gold"], "drum"),
        ("lang-gen.jpg", (61, 107, 74), PALETTE["green"], "wave"),
        ("lang-aja.jpg", (107, 83, 68), PALETTE["bark"], "drum"),
        ("lang-gun.jpg", (47, 104, 64), (26, 77, 46), "wave"),
        ("lang-phera.jpg", (92, 122, 107), (45, 74, 56), "map"),
    ]
    for name, c1, c2, pat in langs:
        save_card(name, (400, 560), c1, c2, pat)

    biblio = [
        ("biblio-books.jpg", PALETTE["bark"], PALETTE["gold"], "book"),
        ("biblio-audio.jpg", PALETTE["green"], PALETTE["green_mid"], "wave"),
        ("biblio-video.jpg", (35, 21, 12), PALETTE["green_mid"], "drum"),
        ("biblio-photos.jpg", PALETTE["gold"], PALETTE["sand"], "map"),
        ("biblio-maps.jpg", PALETTE["green_mid"], (13, 40, 24), "map"),
    ]
    for name, c1, c2, pat in biblio:
        save_card(name, (320, 480), c1, c2, pat)

    gallery_colors = [
        (PALETTE["gold"], PALETTE["bark"]),
        (PALETTE["green"], PALETTE["bark"]),
        (PALETTE["bark"], PALETTE["gold"]),
        (PALETTE["green_mid"], (45, 106, 74)),
        (PALETTE["sand"], PALETTE["gold"]),
        (PALETTE["bark"], PALETTE["green"]),
        (PALETTE["green"], PALETTE["gold"]),
        (PALETTE["gold"], PALETTE["green_mid"]),
        (PALETTE["green_mid"], PALETTE["sand"]),
        (PALETTE["bark"], PALETTE["sand"]),
        (PALETTE["green"], PALETTE["sand"]),
        (PALETTE["gold"], PALETTE["green"]),
    ]
    for i, (c1, c2) in enumerate(gallery_colors, 1):
        save_card(f"gallery-{i:02d}.jpg", (480, 360), c1, c2, "drum" if i % 2 else "wave")

    research = [
        ("research-map.jpg", PALETTE["green_mid"], PALETTE["green"], "map"),
        ("research-book.jpg", PALETTE["bark"], PALETTE["gold"], "book"),
        ("research-code.jpg", (13, 40, 24), PALETTE["green_mid"], "wave"),
        ("research-manuscript.jpg", PALETTE["sand"], PALETTE["bark"], "book"),
        ("research-server.jpg", (35, 21, 12), PALETTE["green"], "wave"),
        ("research-audio.jpg", PALETTE["green"], PALETTE["gold"], "wave"),
    ]
    for name, c1, c2, pat in research:
        save_card(name, (360, 360), c1, c2, pat)

    news = [
        ("news-01.jpg", PALETTE["green"], PALETTE["gold"], "book"),
        ("news-02.jpg", PALETTE["bark"], PALETTE["green_mid"], "drum"),
        ("news-03.jpg", PALETTE["gold"], PALETTE["sand"], "wave"),
    ]
    for name, c1, c2, pat in news:
        save_card(name, (400, 280), c1, c2, pat)

    avatars = [
        ("avatar-01.jpg", PALETTE["green_mid"], PALETTE["green"]),
        ("avatar-02.jpg", PALETTE["bark"], PALETTE["gold"]),
        ("avatar-03.jpg", PALETTE["green"], PALETTE["green_mid"]),
        ("avatar-04.jpg", PALETTE["gold"], PALETTE["bark"]),
    ]
    for name, c1, c2 in avatars:
        img = gradient((256, 256), c1, c2, 45)
        draw = ImageDraw.Draw(img)
        draw.ellipse((48, 48, 208, 208), fill=(255, 250, 240, 40))
        img = add_vignette(img)
        img.save(OUT / name, "JPEG", quality=88, optimize=True)
        print(f"  {name}")

    print("Done.")


if __name__ == "__main__":
    main()
