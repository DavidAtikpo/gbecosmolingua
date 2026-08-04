#!/usr/bin/env python3
"""Prépare les images du slider hero page d'accueil."""

from __future__ import annotations

from pathlib import Path

from PIL import Image

ROOT = Path(__file__).resolve().parents[1]
ASSETS = Path("/home/thecode2/.cursor/projects/home-thecode2-Desktop-gbecosmolingua/assets")
OUT = ROOT / "themes/gbecosmolingua/assets/images/home"
HERO_SIZE = (1920, 900)

SOURCES = {
    "musiciens": ASSETS / "images__7_-92f0dfa4-5cb1-4439-a133-fadfbace38c1.png",
    "ceremonie": ASSETS / "images__8_-b6a445a4-83e9-41b4-96d6-a391aca858ca.png",
    "village": ASSETS / "images__6_-fb569c81-681a-470a-acdd-531be7884f40.png",
    "composite": ASSETS / "Screenshot_From_2026-08-04_01-05-24-d1577cca-9a28-49f9-8852-4dc2efb1c785.png",
}

FOCALS = {
    "musiciens": (0.5, 0.45),
    "ceremonie": (0.5, 0.42),
    "village": (0.55, 0.48),
}


def cover_crop(img: Image.Image, size: tuple[int, int], focal: tuple[float, float] = (0.5, 0.5)) -> Image.Image:
    target_w, target_h = size
    src_w, src_h = img.size
    scale = max(target_w / src_w, target_h / src_h)
    new_w = int(src_w * scale)
    new_h = int(src_h * scale)
    resized = img.resize((new_w, new_h), Image.Resampling.LANCZOS)
    fx, fy = focal
    left = max(0, min(int((new_w - target_w) * fx), new_w - target_w))
    top = max(0, min(int((new_h - target_h) * fy), new_h - target_h))
    return resized.crop((left, top, left + target_w, top + target_h))


def save_jpg(img: Image.Image, path: Path) -> None:
    img.convert("RGB").save(path, "JPEG", quality=90, optimize=True)


def split_composite(img: Image.Image, panels: int = 4) -> list[Image.Image]:
    w, h = img.size
    slice_w = w // panels
    parts: list[Image.Image] = []
    for i in range(panels):
        left = i * slice_w
        right = w if i == panels - 1 else (i + 1) * slice_w
        parts.append(img.crop((left, 0, right, h)))
    return parts


def main() -> None:
    OUT.mkdir(parents=True, exist_ok=True)

    slides = [
        ("hero-slide-01.jpg", "musiciens"),
        ("hero-slide-02.jpg", "ceremonie"),
        ("hero-slide-03.jpg", "village"),
    ]

    for filename, key in slides:
        img = Image.open(SOURCES[key]).convert("RGB")
        save_jpg(cover_crop(img, HERO_SIZE, FOCALS[key]), OUT / filename)
        print(f"  {filename} ← {key}")

    composite = Image.open(SOURCES["composite"]).convert("RGB")
    for i, panel in enumerate(split_composite(composite), start=4):
        filename = f"hero-slide-0{i}.jpg"
        save_jpg(cover_crop(panel, HERO_SIZE, (0.5, 0.5)), OUT / filename)
        print(f"  {filename} ← composite panel {i - 3}")

    first = OUT / "hero-slide-01.jpg"
    for alias in ("hero-patrimoine.jpg",):
        save_jpg(Image.open(first), OUT / alias)
        print(f"  {alias} ← hero-slide-01.jpg")


if __name__ == "__main__":
    main()
