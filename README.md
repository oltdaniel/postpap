# postpap

## Story

This is a social network I started to write in 2015 in 8th/9th grade. It was the first larger project in PHP I wrote from scratch. After this project,
which has also been hosted on postpap.de I moved along, as I reached the limitations of PHP and started developing with NodeJS (which was a bad idea), and quickly switched to CrystalLang and GoLang, where I wrote a similar project with way more efficient setups and real-time action.

## Setup

```bash
# get the code
$ git clone https://github.com/oltdaniel/postpap
$ cd postpap
# start the infrastructure
$ docker-compose up -d
```

1. Open [phpmyadmin import](http://localhost:8080/index.php?route=/server/import) and select the `postpap.sql` and click go.
2. Now visit [`localhost/register.php`](http://localhost/register.php) and create an account.
3. As I've disabled the mail verification (code exists) search the user in [phpmyadmin](http://localhost:8080/index.php?route=/sql&server=1&db=postpap&table=users&pos=0) and copy the `activation_str`. Now call `http://localhost/profile/activate.php?c=ACTIVATION_CODE`.
4. Now login and have fun.

## Issues & Troubleshooting

##### Chat notifications

I guess that I started to write group chats and stopped mid-way, which result in the chat notifications to not work anymore.

##### Registration throws permission errors

During registration, each user gets their own directory by creating a new one and duplicating the  contents of `users/sample`. You can fix this by executing `chmod -R 777 www/users`.

## Learning

As this was the first serious project I wrote in PHP, the lessons I learned where huge. Everything from configuration, encryption basics, and so on, up to realizing every Programming Language has its own limits. This is something I specially learned during implementing the chat. In the first versions I used text files on the server and worked with the filesystem timestamps. I quickly moved up to an mysql table, realizing that PHP is just not made for real-time action. Thus I moved along and wrote newer versions as mentioned in the story above.

## License

_just do, what you'd like to do_

There is a version of some bootstrap, jquery, PHPmailer and so on in here. They have their own license and copyright stuff.