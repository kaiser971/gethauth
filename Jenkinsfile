pipeline {
    agent any

    // Déclencher le pipeline sur les changements de la branche 'dev'
    triggers {
        pollSCM('* * * * *')  // Sonde le SCM toutes les minutes. Ajustez selon les besoins
    }

    environment {
        // Définissez vos variables d'environnement ici si nécessaire
    }

    stages {
        stage('Build') {
            steps {
                // Commandes pour construire votre projet
                echo 'Building...'
                // Exemple : sh 'mvn clean package'
            }
        }

        stage('Test') {
            steps {
                // Commandes pour tester votre projet
                echo 'Testing...'
                // Exemple : sh 'mvn test'
            }
        }

        stage('Deploy') {
            when {
                branch 'dev'  // Exécute cette étape uniquement pour la branche 'dev'
            }
            steps {
                // Commandes pour déployer votre projet
                echo 'Deploying...'
                // Exemple : sh './deploy_script.sh'
            }
        }
    }

    post {
        always {
            // Actions à effectuer après le pipeline, comme le nettoyage
            echo 'Pipeline completed.'
        }
    }
}
