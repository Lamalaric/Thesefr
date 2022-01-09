# Theses.fr

## 📋 Context
Theses.fr was realized as part of a PHP project for my 3rd semester in the DUT Computer Science of Marne-la-Vallée.

Supervised by Dr.Fressin, this project aims to recreate the original [Theses.fr](http://theses.fr) website by adding a dashboard with graphics.


## 🚩 Problems
### Table
Sometimes, when doing your first research, the table containing the results won't show any of them.<br>
It is a server-side problem, which can be fixed by following thoses steps:
- Open the console
- On the first error (red message), click on its first link (in blue)
- It will open a new tab in your browser, containing all the results returned by the code. Just close it.
- Redo your research
- ✅ The table should now shown all theses returned by the research you've made

### Research
Unfortunately, it is not possible (for now, may fix it later), to display all the 500 000 theses of the database by doing a blank search.<br>
Your tab will just enter an infinite load, and show an "Out of memory" error.


## ⚙️ Usage
Here is a typical example of what you can do on this website:
- At the top right of the page, click on the field and type some letters / words in order to find the theses you want to
- Select on which field the database should find the occurence of what you've typed just before, by click on the selector to the close right of the previous field
- Click on the "Rechercher" button to start your research

*Wait for the result being loaded.*
- Once your results have been loaded, you can see :
- A table containing all returned theses
- If a these is available online (on [Theses.fr](http://theses.fr)) you should be able to click on its title to be redirected to the online version of this these
- A graph showing the number of theses made for each year
- The first camembert showing the proprtion of theses available online or not
- The second one is showing the proportion of theses still in progress and sustained
- A map containing markers for every city / school where a these has been made in


## 🔑 Access
You can easily access the website by clicking on this [link](https://etudiant.u-pem.fr/~leforestier/Thesefr/scripts/api.php).
