$ErrorActionPreference = "Continue"
Write-Host "Fetching all remote branches and commits from GitHub..." -ForegroundColor Cyan
git fetch --all --prune

$branches = @(
    "Clive",
    "Daniel",
    "Munie",
    "Nakitto-Shanitah-contribution",
    "Nakitto-Shanitah-contribution-1",
    "macarthy"
)

foreach ($branch in$branches) {
    Write-Host "`n----------------------------------------" -ForegroundColor DarkGray
    Write-Host "Processing branch: $branch" -ForegroundColor Yellow

    git checkout $branch 2>$null
    if ($LASTEXITCODE -ne 0) {
        Write-Host "Creating local tracking branch for origin/$branch..." -ForegroundColor Gray
        git checkout -b $branch "origin/$branch"
    }

    git pull origin $branch --ff-only 2>$null

    Write-Host "Merging origin/main into $branch..." -ForegroundColor Cyan
    git merge origin/main --no-edit

    if ($LASTEXITCODE -ne 0) {
        Write-Host "Merge conflict detected on branch '$branch'!" -ForegroundColor Red
        Write-Host "Please resolve conflicts manually or abort with: git merge --abort" -ForegroundColor Red
        exit 1
    }

    Write-Host "Pushing updated $branch to GitHub..." -ForegroundColor Cyan
    git push origin $branch

    Write-Host "$branch is now completely up-to-date with main!" -ForegroundColor Green
}

git checkout macarthy
Write-Host "`n----------------------------------------" -ForegroundColor DarkGray
Write-Host "ALL group branches are now fully synchronized with main!" -ForegroundColor Green
