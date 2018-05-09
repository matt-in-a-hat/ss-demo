## Silverstripe demo

Used as a base for a presentation about SilverSripe. Probably won't make much sense without a copy of my database (CMS content).

Installed via
`composer create-project silverstripe/installer mscms 4.1.*`

To run:
- `docker-compose up -d`
- `docker-compose exec web composer install`
- `docker-compose exec web ./vendor/silverstripe/framework/sake dev/build`
- `open http://localhost:8000?flush=1`
