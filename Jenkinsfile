pipeline {
    agent any

    triggers {
        pollSCM('H/5 * * * *')
    }

    environment {
        ENV_FILE = '.env'
        APP_ENV = 'dev'
        APP_SECRET = '5e1fec05d027161cfb9a3b9c88eb820b'
        // Ajoutez d'autres variables d'environnement ici si nécessaire
        APP_NAME = 'gethauth'
        APP_SLUG = 'gethauth'
        DB_CONNECTION = 'pdo_mysql'
        DB_HOST = '${APP_SLUG}_database'
        DB_PORT = 3306
        DB_DATABASE = 'scan_sante'
        DB_USERNAME = 'gesthauth'
        DB_PASSWORD = 'root'
        DB_ROOT_PASSWORD = 'root'
        DATABASE_URL = "mysql://${DB_USERNAME}:${DB_PASSWORD}@${DB_HOST}:${DB_PORT}/${DB_DATABASE}?serverVersion=8.0.32&charset=utf8mb4"
        CORS_ALLOW_ORIGIN = '^https?://(localhost|127\\.0\\.0\\.1)(:[0-9]+)?$'
        APP_DEBUG = 1
        GET_USER_INFO_URL = 'https://devel-plage-infoservice.atih.sante.fr/plage-infoservice/getUserInfo.do'
        GET_ETABLISSEMENT_INFO_URL = 'https://devel-plage-infoservice.atih.sante.fr/plage-infoservice/getESInfo.do'
        EMAIL_APPLICATION = 'application_gestauth@atih.sante.fr'
        MAILER_DSN = 'smtp://localhost:1025'
        EMAIL_RESPONSABLE = 'validation_gestauth@atih.sante.fr'
    }

    stages {
        stage('Build and Test') {
            steps {
                script {
                    docker.image('php:8.2-fpm').inside {
                        sh 'composer install'
                        sh 'php bin/console --env=test doctrine:database:create'
                        sh 'php bin/console --env=test doctrine:schema:create'
                        sh 'php bin/console --env=test doctrine:fixtures:load'
                        sh 'php bin/phpunit'
                    }
                }
            }
        }

        stage('Deploy') {
            when {
                branch 'dev'
            }
            steps {
                echo 'Deploying...'
                sshPublisher(publishers: [
                    sshPublisherDesc(
                        configName: "ssh-server-config",
                        transfers: [
                            sshTransfer(
                                sourceFiles: "**/*",
                                removePrefix: "path/to/source",
                                remoteDirectory: "/var/www/gethauth",
                                execCommand: """
                                    cd /var/www/gethauth
                                    git pull
                                    composer install
                                    php bin/console d:m:m
                                """
                            )
                        ]
                    )
                ])
            }
        }
    }

    post {
        always {
            echo 'Pipeline completed.'
        }
    }
}
