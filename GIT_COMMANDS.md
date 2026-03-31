# Git Commands for BusTracker Project

## 🚀 Execute These Commands

### 1. Open Command Prompt/Terminal
- **Windows**: Press `Win + R`, type `cmd`, press Enter

### 2. Navigate to Project Directory
```bash
cd c:/xampp/htdocs/BusTracker
```

### 3. Initialize Git Repository
```bash
git init
```

### 4. Configure Git (if not already done)
```bash
git config --global user.name "Your Name"
git config --global user.email "your.email@example.com"
```

### 5. Add Remote Repository
```bash
git remote add origin https://github.com/Vivid135/BusTracker.git
```

### 6. Add All Files to Staging
```bash
git add .
```

### 7. Create Initial Commit
```bash
git commit -m "Initial commit: ADBU Bus Tracking System with complete functionality"
```

### 8. Push to GitHub
```bash
git branch -M main
git push -u origin main
```

## ✅ Files That Will Be Uploaded

### 📁 Project Files
- ✅ **README.md** - Project documentation
- ✅ **.gitignore** - Git ignore rules
- ✅ **All PHP files** - Complete application
- ✅ **CSS files** - Styling and themes
- ✅ **JavaScript files** - Interactive features
- ✅ **Database schemas** - SQL structure files

### ❌ Files That Will Be Excluded
- ❌ **Database data** (*.sql files in DB/)
- ❌ **Sensitive configs** (.env files)
- ❌ **Logs and cache** (temporary files)
- ❌ **IDE files** (.vscode/, .idea/)
- ❌ **Upload folders** (user content)

## 🎯 Verification

### After Push, Check Your GitHub Repository
1. Visit: https://github.com/Vivid135/BusTracker
2. **README.md should be visible** on the repository page
3. **.gitignore should be in the file list**
4. **All project files should be uploaded**
5. **Excluded files should NOT appear**

## 🔧 Troubleshooting

### If .gitignore is not working:
```bash
# Remove cached files that should be ignored
git rm -r --cached .
git add .
git commit -m "Fixed .gitignore exclusions"
```

### If push fails:
```bash
# Check if remote is correctly set
git remote -v

# Force push if necessary (only if repository is empty)
git push -f origin main
```

### If README.md doesn't show:
1. Check that README.md exists in your local folder
2. Ensure it's not listed in .gitignore
3. Run `git add README.md` specifically
4. Commit and push again

## 🎉 Success Indicators

### ✅ You'll Know It Worked When:
- README.md appears on GitHub repository page
- .gitignore file is visible in the repository
- All your PHP, CSS, JS files are uploaded
- Database files (*.sql) are NOT uploaded
- No sensitive files are exposed

---

**Ready to execute! Run these commands to push your BusTracker project to GitHub!** 🚀
