@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../deployer/deployer/bin/dep
php "%BIN_TARGET%" %*
