# OSSN-HomePagePosts

This component enhances the NewsFeed experience by allowing users to **filter** timeline posts by category and (optionally) **sort them**. It replaces the original dropdown behavior with a modern, always-visible **mobile-friendly filter bar**.

## 🔍 Features

Changes made by compie67
- Always-visible filter bar with icons
- Show timeline posts by:
  - 🌐 Public (all users)
  - 👥 Friends only
  - 🔥 Most liked
- Optional: sort posts in ascending (`↑`) or descending (`↓`) order
- Admins see all posts by default
- Fully compatible with OSSN v6+ and OSSN v8+

Original option
![Screenshot](https://www.rafaelamorim.com.br/temp/homepageposts.png)

## ⚠️ Compatibility

> **Note:** This new version no longer uses the legacy `ossn_get_homepage_wall_access()` or `hpage_posts_get_homepage_wall_access()` functions.  
> old code ask you when using other components that depend on those functions (such as HashTag or PopularPosts), they should be reviewed for compatibility.

## 🛠 Configuration

No admin configuration is required. Users can filter posts directly on the homepage using the filter bar. Sorting is preserved via URL parameters (`?filter=public&sort=asc`).

## ✅ Updates in this version

- Replaced dropdown filters with icon-based filter bar
- Removed deprecated session logic for wall access
- Added optional sort button (ascending/descending)
- Improved post filtering by likes and comments (experimental)
- Restructured code for better debugging and fallback support

## 🧪 Known Issues

- The "Most Commented" and "Liked by Me" filters have fallback logic but may miss edge cases
- Sorting only applies to supported views (e.g. public, friends, liked)

## 📢 Contributing
(phrase from original maker)
Pull requests are welcome!  
For major changes, open an issue first to discuss what you'd like to propose.

Please give insight to me compie67

Please test thoroughly and keep the component lightweight.

## 📄 License

This component is open-source under the [OSSN License](http://www.opensource-socialnetwork.org/licence).
