# Program Card Hover Animations Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Enhance the program card list (01 to 04) on the homepage (`resources/views/landing/sections/programs.blade.php`) with modern, smooth hover animations, shadow transitions, translation effects, and arrow icon translations while maintaining the pristine green pesantren theme.

**Architecture:** Update Tailwind CSS utility classes on the program tab buttons in `resources/views/landing/sections/programs.blade.php` to include smooth transitions (`transition-all duration-300 ease-in-out`), hover elevation/displacement (`hover:-translate-y-0.5 hover:translate-x-1`), enhanced shadows (`hover:shadow-md hover:shadow-emerald-950/5`), border/background contrast enhancements, and arrow icon translation (`group-hover:translate-x-1 transition-transform`).

**Tech Stack:** Laravel Blade, Tailwind CSS v3/v4.

## Global Constraints
- Maintain PHP 8.4 and Laravel app conventions.
- Keep the existing Alpine.js tab switching logic intact (`data-program-tab`, `data-program-panel`, `aria-selected`).
- Ensure code style passes `vendor/bin/pint --format agent`.

---

### Task 1: Update Program Card Buttons with Enhanced Hover and Arrow Animations

**Files:**
- Modify: `resources/views/landing/sections/programs.blade.php:22-40`

- [ ] **Step 1: Edit `resources/views/landing/sections/programs.blade.php` to add advanced transition and hover classes**

Replace lines 22-40 with:
```html
                        <button
                            type="button"
                            role="tab"
                            id="tab-{{ $program['id'] }}"
                            aria-controls="panel-{{ $program['id'] }}"
                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                            data-program-tab="{{ $program['id'] }}"
                            class="group flex min-w-[220px] items-center gap-4 rounded-2xl border px-4 py-4 text-left transition-all duration-300 ease-in-out lg:min-w-0 {{ $index === 0 ? 'border-emerald-900 bg-emerald-900 text-cream-50 shadow-md shadow-emerald-950/20 hover:-translate-y-0.5 hover:translate-x-1 hover:bg-emerald-950 hover:shadow-lg hover:shadow-emerald-950/30' : 'border-emerald-900/10 bg-white/70 text-emerald-950 hover:-translate-y-0.5 hover:translate-x-1 hover:border-emerald-900/35 hover:bg-white hover:shadow-md hover:shadow-emerald-950/10' }}"
                        >
                            <span class="font-arabic text-lg opacity-60 transition-opacity duration-300 group-hover:opacity-100">0{{ $index + 1 }}</span>
                            <span class="flex-1">
                                <span class="block text-sm font-semibold transition-colors duration-300 group-hover:text-emerald-900 {{ $index === 0 ? 'group-hover:text-cream-50' : '' }}">{{ $program['title'] }}</span>
                                <span class="mt-0.5 block text-xs opacity-70 transition-opacity duration-300 group-hover:opacity-90">{{ $program['tag'] }}</span>
                            </span>
                            <svg viewBox="0 0 20 20" class="h-4 w-4 shrink-0 opacity-60 transition-all duration-300 group-hover:translate-x-1 group-hover:opacity-100 {{ $index === 0 ? 'text-cream-50' : 'text-emerald-900' }}" fill="none" aria-hidden="true">
                                <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
```

- [ ] **Step 2: Clear cache and compile assets**

Run: `php artisan config:clear; php artisan view:clear; npm run build`
Expected: Success without errors.

- [ ] **Step 3: Run test suite**

Run: `php artisan test`
Expected: PASS (75 tests passed)

- [ ] **Step 4: Commit changes**

```bash
git add resources/views/landing/sections/programs.blade.php
git commit -m "feat: enhance program cards with smooth hover animations and arrow transitions"
```
