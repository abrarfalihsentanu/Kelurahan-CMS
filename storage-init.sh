#!/bin/bash

# ============================================================================
# SCRIPT: Auto-Initialize Storage Folders untuk Upload
# GUNAKAN: sh storage-init.sh
# ============================================================================

echo "🚀 Initializing Storage Folders for Image Uploads..."
echo ""

# Color codes
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Step 1: Create storage:link
echo -e "${YELLOW}1️⃣  Creating storage symlink...${NC}"
php artisan storage:link 2>/dev/null
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Symlink created successfully${NC}"
else
    echo -e "${YELLOW}⚠️  Symlink attempt completed (may already exist)${NC}"
fi

echo ""

# Step 2: Create all required subdirectories
echo -e "${YELLOW}2️⃣  Creating image storage subdirectories...${NC}"

FOLDERS=(
    "storage/app/public/sliders"
    "storage/app/public/news"
    "storage/app/public/galleries"
    "storage/app/public/achievements"
    "storage/app/public/services"
    "storage/app/public/infographics"
    "storage/app/public/pages"
    "storage/app/public/potentials"
    "storage/app/public/officials"
    "storage/app/public/complaints"
)

for folder in "${FOLDERS[@]}"; do
    mkdir -p "$folder"
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✅ Created: $folder${NC}"
    else
        echo -e "${RED}❌ Failed to create: $folder${NC}"
    fi
done

echo ""

# Step 3: Fix permissions
echo -e "${YELLOW}3️⃣  Setting file permissions...${NC}"
sudo chown -R www-data:www-data storage/ 2>/dev/null
sudo chmod -R 755 storage/ 2>/dev/null

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Permissions set successfully${NC}"
else
    echo -e "${YELLOW}⚠️  Permission setting attempted (may require sudo)${NC}"
fi

echo ""

# Step 4: Clear cache
echo -e "${YELLOW}4️⃣  Clearing Laravel cache...${NC}"
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear

echo ""

# Step 5: Verify
echo -e "${YELLOW}5️⃣  Verifying setup...${NC}"
echo ""

for folder in "${FOLDERS[@]}"; do
    if [ -d "$folder" ]; then
        echo -e "${GREEN}✅ EXISTS: $folder${NC}"
    else
        echo -e "${RED}❌ MISSING: $folder${NC}"
    fi
done

echo ""
echo -e "${YELLOW}6️⃣  Checking symlink...${NC}"
if [ -L "public/storage" ]; then
    TARGET=$(readlink public/storage)
    echo -e "${GREEN}✅ Symlink exists: public/storage -> $TARGET${NC}"
else
    echo -e "${RED}❌ Symlink does not exist${NC}"
fi

echo ""
echo -e "${GREEN}================================${NC}"
echo -e "${GREEN}✅ Storage initialization complete!${NC}"
echo -e "${GREEN}================================${NC}"
echo ""
echo "📋 Next steps:"
echo "1. Upload a test image in Admin → Slider"
echo "2. Verify image exists: ls -la storage/app/public/sliders/"
echo "3. Test URL: http://your-domain.id/storage/sliders/filename.png"
echo ""
