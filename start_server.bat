@echo off
set PHP_EXE="C:\Users\HP\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.2_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe"
set PHP_INI="C:\Users\HP\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.2_Microsoft.Winget.Source_8wekyb3d8bbwe\php.ini"

echo ======================================================
echo   Starting HRMS Server with Stable PHP 8.2 (MySQL)
echo ======================================================
echo.

%PHP_EXE% -c %PHP_INI% artisan serve
pause

