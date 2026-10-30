#!/usr/bin/env python3
"""Convertit les photos artisanat (.jfif) en JPEG pour le hub Cultures Gbe."""

from __future__ import annotations

from pathlib import Path

from PIL import Image

ROOT = Path(__file__).resolve().parents[1]
SRC_DIR = ROOT / "themes/gbecosmolingua/assets/images/artisanat"
OUT_DIR = ROOT / "themes/gbecosmolingua/assets/images/culture-gbe"

# Ordre stable : tri alphabétique des fichiers source.
TARGETS = [
    ("hero-culture.jpg", (1920, 900), (0.5, 0.45)),
    ("arts-artisanat.jpg", (1200, 800), (0.5, 0.5)),
    ("artisanat-techniques.jpg", (800, 560), (0.5, 0.5)),
    ("artisanat-savoir-faire.jpg", (800, 560), (0.5, 0.5)),
    ("artisanat-transmission.jpg", (800, 560), (0.5, 0.5)),
    ("arts-sculpture.jpg", (1200, 800), (0.5, 0.5)),
    ("arts-tissage.jpg", (800, 560), (0.5, 0.45)),
    ("arts-poterie.jpg", (800, 560), (0.5, 0.5)),
    ("galerie-1.jpg", (640, 480), (0.5, 0.5)),
    ("galerie-2.jpg", (640, 480), (0.5, 0.5)),
]


def cover_crop(img: Image.Image, size: tuple[int, int], focal: tuple[float, float] = (0.5, 0.5)) -> Image.Image:
    target_w, target_h = size
    src_w, src_h = img.size
    scale = max(target_w / src_w, target_h / src_h)
    new_w = int(src_w * scale)
    new_h = int(src_h * scale)
    resized = img.resize((new_w, new_h), Image.Resampling.LANCZOS)
    fx, fy = focal
    left = int((new_w - target_w) * fx)
    top = int((new_h - target_h) * fy)
    left = max(0, min(left, new_w - target_w))
    top = max(0, min(top, new_h - target_h))
    return resized.crop((left, top, left + target_w, top + target_h))


def save_jpg(img: Image.Image, path: Path, quality: int = 88) -> None:
    rgb = img.convert("RGB")
    rgb.save(path, "JPEG", quality=quality, optimize=True)


def main() -> None:
    sources = sorted(SRC_DIR.glob("*.jfif"))
    if not sources:
        sources = sorted(SRC_DIR.glob("*.jpg")) + sorted(SRC_DIR.glob("*.jpeg"))
    if not sources:
        raise SystemExit(f"Aucune image dans {SRC_DIR}")

    OUT_DIR.mkdir(parents=True, exist_ok=True)
    loaded = [Image.open(p).convert("RGB") for p in sources]

    for i, (name, size, focal) in enumerate(TARGETS):
        img = loaded[i % len(loaded)]
        out = OUT_DIR / name
        save_jpg(cover_crop(img, size, focal), out)
        print(f"  {out.name}  ←  {sources[i % len(sources)].name}")

    # Galerie : réutiliser les sources restantes si besoin.
    for j, name in enumerate(("galerie-3.jpg", "galerie-4.jpg", "galerie-5.jpg"), start=len(TARGETS)):
        img = loaded[j % len(loaded)]
        out = OUT_DIR / name
        save_jpg(cover_crop(img, (640, 480), (0.5, 0.5)), out)
        print(f"  {out.name}  ←  {sources[j % len(sources)].name}")

    print(f"\n{len(list(OUT_DIR.glob('*.jpg')))} fichiers dans {OUT_DIR}")


if __name__ == "__main__":
    main()
