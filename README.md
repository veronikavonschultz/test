# Test completed by Veronika von Schultz

This is my solution to the Back-end Developer Test by Cult Beauty. The application allows a user to search GitHub for repositories with a description matching the specified search query.



## Usage

```bash
php search.php search_term
```

The search_term can be any string with one or more words and will be treated as a phrase to be matched rather than individual words. If left empty, the application will respond "Please provide a search term".


### Restrictions

1. The application will load at most the first 1000 results to any query. 

2. Any repositories that do not have a language specified are ignored.



## Example

A query such as 

```bash
php search.php shampoo
```

will return something like

```bash
JavaScript: 6
Python: 5
Jupyter Notebook: 5
R: 2
HTML: 2
CSS: 2
Java: 1
PHP: 1
Go: 1
Emacs Lisp: 1
TypeScript: 1
=> 45 total result(s) found
```