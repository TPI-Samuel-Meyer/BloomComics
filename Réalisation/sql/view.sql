SELECT `article`,avg(`mark`) AS `AVG(mark)` from `mark_as_article` group by `article`