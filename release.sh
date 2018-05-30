#!/bin/bash

VERSION=$1
BUILD=$2

echo "Creating release $VERSION.$BUILD"

git checkout -b release/$VERSION.$BUILD &&
touch CHANGELOG.md

cat <<EOF | xargs -0 -I {} bash -c {} | sponge CHANGELOG.md
printf "# Changelog\n\n"
printf "## Version $VERSION.$BUILD created on `date +%Y-%m-%d`\n\n"
git --no-pager log --no-merges --format="* \\\`%h\\\` %s (%aN)" `[[ $(git tag | wc -l) = "0" ]] && git rev-list --max-parents=0 HEAD || git rev-list --tags --max-count=1`..$GIT_COMMIT
printf "\n"
cat CHANGELOG.md | sed 1,2d
EOF

git add CHANGELOG.md &&
git commit -am "Release version $VERSION.$BUILD" && \
git checkout master &&
git pull &&
git merge --no-ff release/$VERSION.$BUILD -m "Merged release/$VERSION.$BUILD into master" && \
git tag -a $VERSION.$BUILD -m "$VERSION.$BUILD" && \
git checkout develop && \
git merge --no-ff release/$VERSION.$BUILD  -m "Merged release/$VERSION.$BUILD into develop" && \
git branch -d release/$VERSION.$BUILD && \
echo "Release $VERSION.$BUILD created"
git pull && \
git push --all && git push origin $VERSION.$BUILD && \
echo "Release pushed to the repository"
