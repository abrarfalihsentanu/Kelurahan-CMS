@echo off
REM ============================================================================
REM SCRIPT: Auto-Initialize Storage Folders untuk Upload (Windows)
REM GUNAKAN: storage-init.bat (double-click atau run di terminal)
REM ============================================================================

color 0A
echo.
echo ============================================================
echo   Storage Initialization for Image Uploads (Windows)
echo ============================================================
echo.

REM Step 1: Create storage:link
echo [1/4] Creating storage symlink...
php artisan storage:link
if %ERRORLEVEL% EQU 0 (
    echo.
    echo [OK] Symlink created successfully
) else (
    echo.
    echo [INFO] Symlink may already exist or encountered an issue
)

echo.

REM Step 2: Create all required subdirectories
echo [2/4] Creating image storage subdirectories...

setlocal enabledelayedexpansion
set "folders=sliders news galleries achievements services infographics pages potentials officials complaints"

for %%f in (%folders%) do (
    if not exist "storage\app\public\%%f" (
        mkdir "storage\app\public\%%f"
        echo   [OK] Created: storage\app\public\%%f
    ) else (
        echo   [SKIP] Exists: storage\app\public\%%f
    )
)

echo.

REM Step 3: Clear cache
echo [3/4] Clearing Laravel cache...
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear

echo.

REM Step 4: Verification
echo [4/4] Verifying setup...
echo.

setlocal enabledelayedexpansion
for %%f in (%folders%) do (
    if exist "storage\app\public\%%f" (
        echo   [YES] storage\app\public\%%f
    ) else (
        echo   [NO]  storage\app\public\%%f - MISSING!
    )
)

echo.
echo ============================================================
echo   Storage initialization complete!
echo ============================================================
echo.
echo Next steps:
echo   1. Upload a test image in Admin ^> Slider
echo   2. Check: storage\app\public\sliders\
echo   3. Test URL: http://localhost:8000/storage/sliders/filename.png
echo.
echo Press any key to continue...
pause>nul
