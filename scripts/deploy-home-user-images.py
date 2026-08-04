#!/usr/bin/env python3
"""Déploie les images culturelles fournies sur la page d'accueil."""

from __future__ import annotations

from pathlib import Path

from PIL import Image

ROOT = Path(__file__).resolve().parents[1]
ASSETS = Path("/home/thecode2/.cursor/projects/home-thecode2-Desktop-gbecosmolingua/assets")
OUT = ROOT / "themes/gbecosmolingua/assets/images/home"

SOURCES = {
    "architecture": ASSETS / "download-1ab64a15-cc35-4ab2-b072-1a4bece2e94c.png",
    "corridor": ASSETS / "download__1_-9f759e3b-20f8-44ce-9c7d-438fc445cda9.png",
    "danse_togo": ASSETS / "images__5_-03df3759-5594-4dc0-ab62-de8a9dabdf5c.png",
    "echassiers": ASSETS / "Echassiers.-630x381-1-667e3bf7-003e-4cd5-8255-d0315a04230f.png",
    "danse_raffia": ASSETS / "images__4_-0ad631c2-7829-4999-ae51-5811fb3d7f86.png",
    "village": ASSETS / "istockphoto-619526528-612x612-9cd6a79b-5c01-4eb6-ad5f-4e7364a7e217.png",
}


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


def load(key: str) -> Image.Image:
    path = SOURCES[key]
    if not path.exists():
        raise FileNotFoundError(path)
    return Image.open(path).convert("RGB")


def main() -> None:
    OUT.mkdir(parents=True, exist_ok=True)
    images = {key: load(key) for key in SOURCES}

    mapping: list[tuple[str, str, tuple[int, int], tuple[float, float]]] = [
        ("hero-patrimoine.jpg", "architecture", (1920, 900), (0.45, 0.5)),
        ("map-preview.jpg", "village", (960, 640), (0.5, 0.45)),
        ("news-01.jpg", "danse_togo", (520, 340), (0.5, 0.4)),
        ("news-02.jpg", "echassiers", (520, 340), (0.55, 0.45)),
        ("news-03.jpg", "danse_raffia", (520, 340), (0.5, 0.42)),
        ("lang-ewe.jpg", "danse_togo", (520, 650), (0.5, 0.35)),
        ("lang-gen.jpg", "danse_raffia", (520, 650), (0.48, 0.4)),
        ("lang-fon.jpg", "corridor", (520, 650), (0.35, 0.5)),
        ("lang-aja.jpg", "architecture", (520, 650), (0.55, 0.45)),
        ("lang-gun.jpg", "corridor", (520, 650), (0.65, 0.5)),
        ("lang-phera.jpg", "village", (520, 650), (0.5, 0.5)),
        ("biblio-books.jpg", "architecture", (560, 380), (0.5, 0.45)),
        ("biblio-audio.jpg", "danse_raffia", (560, 380), (0.5, 0.4)),
        ("biblio-video.jpg", "echassiers", (560, 380), (0.5, 0.45)),
        ("biblio-photos.jpg", "danse_togo", (560, 380), (0.5, 0.38)),
        ("biblio-maps.jpg", "village", (560, 380), (0.5, 0.45)),
        ("research-map.jpg", "village", (420, 420), (0.5, 0.45)),
        ("research-book.jpg", "architecture", (420, 420), (0.5, 0.5)),
        ("research-code.jpg", "echassiers", (420, 420), (0.55, 0.45)),
        ("research-manuscript.jpg", "corridor", (420, 420), (0.4, 0.5)),
        ("research-server.jpg", "corridor", (420, 420), (0.7, 0.45)),
        ("research-audio.jpg", "danse_raffia", (420, 420), (0.5, 0.42)),
        ("gallery-01.jpg", "architecture", (880, 560), (0.45, 0.5)),
        ("gallery-02.jpg", "corridor", (440, 280), (0.35, 0.5)),
        ("gallery-03.jpg", "danse_togo", (440, 280), (0.5, 0.38)),
        ("gallery-04.jpg", "echassiers", (440, 280), (0.55, 0.45)),
        ("gallery-05.jpg", "danse_raffia", (880, 560), (0.5, 0.42)),
        ("gallery-06.jpg", "village", (440, 280), (0.5, 0.45)),
        ("gallery-07.jpg", "corridor", (440, 280), (0.55, 0.5)),
        ("gallery-08.jpg", "danse_togo", (880, 560), (0.5, 0.35)),
        ("gallery-09.jpg", "echassiers", (440, 280), (0.45, 0.45)),
        ("gallery-10.jpg", "danse_raffia", (440, 280), (0.52, 0.4)),
        ("gallery-11.jpg", "village", (440, 280), (0.6, 0.45)),
        ("gallery-12.jpg", "architecture", (440, 280), (0.65, 0.45)),
        ("avatar-01.jpg", "danse_togo", (320, 320), (0.42, 0.32)),
        ("avatar-02.jpg", "echassiers", (320, 320), (0.35, 0.4)),
        ("avatar-03.jpg", "danse_raffia", (320, 320), (0.48, 0.38)),
        ("avatar-04.jpg", "corridor", (320, 320), (0.35, 0.55)),
    ]

    for filename, key, size, focal in mapping:
        cropped = cover_crop(images[key], size, focal)
        save_jpg(cropped, OUT / filename)
        print(f"  {filename} ← {key}")

    hero_xotutu = cover_crop(images["danse_raffia"], (1200, 720), (0.5, 0.42))
    hero_xotutu.save(OUT / "heroxotutu.png", "PNG", optimize=True)
    print("  heroxotutu.png ← danse_raffia")

    print(f"\n{len(mapping) + 1} fichiers écrits dans {OUT}")


if __name__ == "__main__":
    main()
