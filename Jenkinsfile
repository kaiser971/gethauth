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
        CORS_ALLOW_ORIGIN = '^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$'
        APP_DEBUG = 1
        GET_USER_INFO_URL = 'https://devel-plage-infoservice.atih.sante.fr/plage-infoservice/getUserInfo.do'
        GET_ETABLISSEMENT_INFO_URL = 'https://devel-plage-infoservice.atih.sante.fr/plage-infoservice/getESInfo.do'
        EMAIL_APPLICATION = 'application_gestauth@atih.sante.fr'
        MAILER_DSN = 'smtp://localhost:1025'
        EMAIL_RESPONSABLE = 'validation_gestauth@atih.sante.fr'
    }

    stages {
        stage('Build') {
            steps {
                echo 'Building...'
                sh 'docker-compose -f docker-compose.yml build'
                sh 'docker-compose -f docker-compose.yml up -d'
                sh 'docker-compose -f docker-compose.yml exec php php bin/console --env=test doctrine:database:create'
                sh 'docker-compose -f docker-compose.yml exec php php bin/console --env=test doctrine:schema:create'
                sh 'docker-compose -f docker-compose.yml exec php php bin/console --env=test doctrine:fixtures:load'
                sh 'docker-compose -f docker-compose.yml down'
            }
        }


        stage('Test') {
            steps {
                echo 'Testing...'
                sh 'docker-compose -f docker-compose.yml up -d'
                script {
                    try {
                        sh 'docker-compose -f docker-compose.yml exec php php bin/phpunit'
                    } catch (Exception e) {
                        echo 'Tests failed'
                        throw e // Ceci renvoie un échec de pipeline si les tests échouent
                    }
                }
                sh 'docker-compose -f docker-compose.yml down'
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
                            configName: "root (ssh jenkins?)",
                            transfers: [
                                sshTransfer(
                                    sourceFiles: "docker-compose.yml, .env, etc",
                                    removePrefix: "path/to/source",
                                    remoteDirectory: "var/www/gethauth",
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
            // Nettoyage ou autres actions post-pipeline
        }
    }
}
