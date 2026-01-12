#!/bin/bash

# GitHub Actions Deployment - Quick Deploy Script
# This script helps you quickly commit and push changes to trigger deployment

set -e

echo "🚀 GitHub Actions Deployment Helper"
echo "===================================="
echo ""

# Check if there are changes
if [[ -z $(git status -s) ]]; then
    echo "⚠️  No changes to commit!"
    echo "Make some changes first, then run this script again."
    exit 0
fi

# Show status
echo "📋 Changes to be deployed:"
echo ""
git status -s
echo ""

# Get commit message
read -p "📝 Enter commit message: " commit_message

if [ -z "$commit_message" ]; then
    echo "❌ Commit message cannot be empty!"
    exit 1
fi

# Confirm deployment
echo ""
echo "Ready to deploy with message: '$commit_message'"
read -p "Continue? (y/n): " confirm

if [ "$confirm" != "y" ] && [ "$confirm" != "Y" ]; then
    echo "❌ Deployment cancelled"
    exit 0
fi

# Deploy
echo ""
echo "🔄 Adding files..."
git add .

echo "💾 Committing..."
git commit -m "$commit_message"

echo "📤 Pushing to GitHub..."
git push origin main

echo ""
echo "✅ Code pushed to GitHub!"
echo "🌐 Check deployment status: https://github.com/DevCleon-TheFirst/portfolio/actions"
echo ""
echo "Your changes will be deployed automatically by GitHub Actions."
echo "Monitor the deployment in the Actions tab of your repository."
