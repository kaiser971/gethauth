pipeline {
    agent any

    // Déclencher le pipeline sur les changements de la branche 'dev'
    triggers {
        pollSCM('H/5 * * * *')  // Sonde le SCM toutes les 5 minutes. Ajustez selon les besoins
    }

    environment {
        // Exemple de variable d'environnement
        TEST_ENV_VARIABLE = 'valeurDeTest'
    }

    stages {
        stage('Build') {
            steps {
                // Commande de build fictive
                echo 'Building...'
                sh 'echo "Simulation du processus de build"'
                // Remplacez par vos propres commandes de build
            }
        }

        stage('Test') {
            steps {
                // Commande de test fictive
                echo 'Testing...'
                sh 'echo "Simulation des tests"'
                // Remplacez par vos propres commandes de test
            }
        }

        stage('Deploy') {
            when {
                branch 'dev'  // Exécute cette étape uniquement pour la branche 'dev'
            }
            steps {
                // Commande de déploiement fictive
                echo 'Deploying...'
                sh 'echo "Simulation du déploiement"'
                // Remplacez par vos propres commandes de déploiement
            }
        }
    }

    post {
        always {
            // Actions après le pipeline
            echo 'Pipeline completed.'
            sh 'echo "Nettoyage et autres actions post-pipeline"'
            // Ajoutez ici des commandes de nettoyage ou de notification
        }
    }
}
