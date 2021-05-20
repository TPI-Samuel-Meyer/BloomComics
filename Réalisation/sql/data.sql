USE `bloomcomics`;

INSERT INTO types (`id`, `name`)
VALUES
(1, 'Anime'),
(2, 'Cartoon'),
(3, 'Comics'),
(4, 'Manga'),
(5, 'Movie')

INSERT INTO artworks (`id`, `ui`, `title`, `description`, `releaseDate`, `editor`, `type`)
VALUES
(1, 'vRAvyN7naWf79PztLDfmmKUwVjDZH7XV', 'Cowboy Bebop', "In the year 2071, humanity has colonized several of the planets and moons of the solar system leaving the now uninhabitable surface of planet Earth behind. The Inter Solar System Police attempts to keep peace in the galaxy, aided in part by outlaw bounty hunters, referred to as 'Cowboys.' The ragtag team aboard the spaceship Bebop are two such individuals. Mellow and carefree Spike Spiegel is balanced by his boisterous, pragmatic partner Jet Black as the pair makes a living chasing bounties and collecting rewards. Thrown off course by the addition of new members that they meet in their travels—Ein, a genetically engineered, highly intelligent Welsh Corgi; femme fatale Faye Valentine, an enigmatic trickster with memory loss; and the strange computer whiz kid Edward Wong—the crew embarks on thrilling adventures that unravel each member's dark and mysterious past little by little. Well-balanced with high density action and light-hearted comedy, Cowboy Bebop is a space Western classic and an homage to the smooth and improvised music it is named after.", '1998-04-03', 'Hajime Yatate', 1),
(2, 'kMcq8qp6ddPZpQtqMkgdp4ngFu9LmcDv', 'Rick and Morty', "Rick is an eccentric and alcoholic mad scientist, who eschews many ordinary conventions such as school, marriage, love, and family. He frequently goes on adventures with his 14-year-old grandson, Morty, a kind-hearted but easily distressed boy, whose naïve but grounded moral compass plays counterpoint to Rick's Machiavellian ego. Morty's 17-year-old sister, Summer, is a more conventional teenager who worries about improving her status among her peers and sometimes follows Rick and Morty on their adventures. The kids' mother, Beth, is a generally level-headed person and assertive force in the household, though self-conscious about her professional role as a horse surgeon. She is dissatisfied with her marriage to Jerry, a simple-minded and insecure person, who disapproves of Rick's influence over his family.", '2013-12-02', 'Dan Harmon, Justin Roiland', 2)

INSERT INTO articles (`ui`, `title`, `description`, `artwork`, `releaseDate`, `author`)
VALUES
('6HEsx8kpnXWXuYjNcpST6GyEJNQCcatv', 'Rick and Morty Season 1', "Rick is an eccentric and alcoholic mad scientist, who eschews many ordinary conventions such as school, marriage, love, and family. He frequently goes on adventures with his 14-year-old grandson, Morty, a kind-hearted but easily distressed boy, whose naïve but grounded moral compass plays counterpoint to Rick's Machiavellian ego. Morty's 17-year-old sister, Summer, is a more conventional teenager who worries about improving her status among her peers and sometimes follows Rick and Morty on their adventures. The kids' mother, Beth, is a generally level-headed person and assertive force in the household, though self-conscious about her professional role as a horse surgeon. She is dissatisfied with her marriage to Jerry, a simple-minded and insecure person, who disapproves of Rick's influence over his family.", 2, '2013-12-02', 42),
('qy5GuTK9HGEaRQSLLkkGZYBXuN75wv6X', 'Rick and Morty Season 2', '', 2, '2015-07-26', 42),
('D7us9dbxwV7AfqDJwevGAdWaZSuWd8f3', 'Rick and Morty Season 3', '', 2, '2017-04-01', 42),
('7R8kpKTdQDyAp6DweWRkspC43AQ5Dt5m', 'Rick and Morty Season 4', '', 2, '2019-11-10', 42),
('CahcyBuGn3JdYCRBTWXxmF6NQ5dVB89a', 'Rick and Morty Specials', '', 2, '2020-03-29', 42),
('Kf85cfAPYSz5N2Mn84shJjBJhfBjRMT2', 'Rick and Morty Season 5', '', 2, '2021-06-20', 42)
