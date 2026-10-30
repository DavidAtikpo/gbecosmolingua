#!/usr/bin/env python3
"""Parse corpus proverbes éwé (texte brut) → JSON pour GbeCosmoLingua."""

from __future__ import annotations

import json
import re
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
SOURCE = ROOT / "data" / "proverbes-ewe-source.txt"
OUTPUT = ROOT / "plugins" / "gbecosmolingua-core" / "data" / "proverbes-ewe.json"

SOURCE_SPIETH = (
    "Corpus éwé — Les communautés éwé (Die Ewe-Stämme), Jakob Spieth, 1906."
)
SOURCE_GBEKOBU = (
    "Corpus éwé — Eʋegbe fe dzè kple Atadi alo Lododowo kple Adaganawo, "
    "Kofi Nɔgbenakpɔe Gbekɔbu, 2014 ; "
    "Lãwo fe gbe : Lododo tso Lãwo ŋu, Benedicta Esi Anibri, 2003."
)
SOURCE_ADOGLO = (
    "Corpus éwé — Lododowo / Adoglo (traditions orales animales), "
    "Gbekɔbu (2014) et sources complémentaires."
)


def source_for_number(num: int) -> tuple[str, str]:
    if num <= 128:
        return "spieth_1906", SOURCE_SPIETH
    if num <= 592:
        return "gbekobu_2014", SOURCE_GBEKOBU
    return "adoglo", SOURCE_ADOGLO


def parse_lines(lines: list[str]) -> list[dict]:
    items: list[dict] = []
    current_num: int | None = None
    current_parts: list[str] = []

    entry_re = re.compile(r"^(\d+)\.\s+(.*)$")

    def flush() -> None:
        nonlocal current_num, current_parts
        if current_num is None:
            return
        text = " ".join(part.strip() for part in current_parts if part.strip())
        text = re.sub(r"\s+", " ", text).strip()
        if text:
            key, source = source_for_number(current_num)
            items.append(
                {
                    "num": current_num,
                    "text": text,
                    "source_key": key,
                    "source": source,
                    "langue": "Éwé",
                }
            )
        current_num = None
        current_parts = []

    for raw in lines:
        line = raw.strip()
        if not line:
            continue
        if line.startswith("Les proverbes") or line.startswith("Œuvre"):
            continue
        if line.startswith("---"):
            continue

        match = entry_re.match(line)
        if match:
            flush()
            current_num = int(match.group(1))
            current_parts = [match.group(2).strip()]
        elif current_num is not None:
            current_parts.append(line)

    flush()
    return items


def main() -> int:
    source_path = Path(sys.argv[1]) if len(sys.argv) > 1 else SOURCE
    output_path = Path(sys.argv[2]) if len(sys.argv) > 2 else OUTPUT

    if not source_path.is_file():
        print(f"Fichier source introuvable : {source_path}", file=sys.stderr)
        return 1

    text = source_path.read_text(encoding="utf-8")
    items = parse_lines(text.splitlines())
    items.sort(key=lambda x: x["num"])

    output_path.parent.mkdir(parents=True, exist_ok=True)
    output_path.write_text(
        json.dumps(items, ensure_ascii=False, indent=2) + "\n",
        encoding="utf-8",
    )

    nums = [i["num"] for i in items]
    print(f"Écrit {len(items)} proverbes → {output_path}")
    if nums:
        print(f"Numéros : {min(nums)}–{max(nums)}")
    missing = [n for n in range(1, max(nums) + 1) if n not in set(nums)] if nums else []
    if missing:
        print(f"Numéros manquants ({len(missing)}) : {missing[:20]}{'…' if len(missing) > 20 else ''}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
