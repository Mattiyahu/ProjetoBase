<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SurveySection;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionOption;
use Illuminate\Support\Facades\Log;

class SurveySeeder extends Seeder
{
    public function run()
    {
        Log::info('Starting SurveySeeder');

        try {
            $sections = [
                [
                    'title' => 'Informações Pessoais',
                    'order' => 1,
                    'questions' => [
                        [
                            'text' => 'Qual é o seu peso atual (kg)?',
                            'type' => 'number',
                            'order' => 1,
                        ],
                        [
                            'text' => 'Qual é o seu sexo?',
                            'type' => 'radio',
                            'order' => 2,
                            'options' => ['Masculino', 'Feminino']
                        ],
                        [
                            'text' => 'Qual é a sua data de nascimento?',
                            'type' => 'date',
                            'order' => 3,
                        ],
                        [
                            'text' => 'Qual é a sua altura (cm)?',
                            'type' => 'number',
                            'order' => 4,
                        ]
                    ]
                ],
                [
                    'title' => 'Saúde Mental',
                    'order' => 2,
                    'questions' => [
                        [
                            'text' => 'Você já foi diagnosticado(a) com algum transtorno mental?',
                            'type' => 'select',
                            'order' => 1,
                            'options' => [
                                'Depressão', 'Transtorno Bipolar', 'Transtorno de Ansiedade Generalizada',
                                'Síndrome do Pânico', 'Fobias', 'Transtorno do Espectro Autista',
                                'Déficit de Atenção e Hiperatividade', 'Bulimia', 'Anorexia',
                                'Transtorno da Compulsão Alimentar Periódica', 'Não'
                            ]
                        ],
                        [
                            'text' => 'Com que frequência você apresenta sintomas?',
                            'type' => 'radio',
                            'order' => 2,
                            'options' => ['Nunca', 'Raramente', 'Às vezes', 'Frequentemente', 'Sempre']
                        ],
                        [
                            'text' => 'Você está atualmente recebendo algum tipo de tratamento para sua saúde mental?',
                            'type' => 'select',
                            'order' => 3,
                            'options' => ['Medicamentos', 'Terapia', 'Ambos', 'Nenhum']
                        ],
                        [
                            'text' => 'Você acredita que seus hábitos alimentares influenciam seu humor e emoções?',
                            'type' => 'radio',
                            'order' => 4,
                            'options' => ['Sim', 'Não', 'Não sei']
                        ]
                    ]
                ],
                [
                    'title' => 'Usabilidade',
                    'order' => 3,
                    'questions' => [
                        [
                            'text' => 'O que você espera de um aplicativo de saúde mental e alimentação?',
                            'type' => 'select',
                            'order' => 1,
                            'options' => ['Monitoramento de refeições', 'Dicas de bem-estar', 'Acompanhamento com profissionais', 'Outros']
                        ],
                        [
                            'text' => 'Com que frequência você gostaria de receber notificações?',
                            'type' => 'select',
                            'order' => 2,
                            'options' => ['Diariamente', 'Algumas vezes por semana', 'Apenas quando necessário']
                        ]
                    ]
                ],
                [
                    'title' => 'Objetivos, Desafios e Motivações',
                    'order' => 4,
                    'questions' => [
                        [
                            'text' => 'O que você gostaria de melhorar em sua alimentação?',
                            'type' => 'textarea',
                            'order' => 1,
                        ],
                        [
                            'text' => 'O que te motiva a cuidar melhor da sua saúde mental e física?',
                            'type' => 'textarea',
                            'order' => 2,
                        ],
                        [
                            'text' => 'Quais são os maiores desafios para manter uma alimentação saudável?',
                            'type' => 'select',
                            'order' => 3,
                            'options' => ['Falta de tempo', 'Custo', 'Falta de motivação', 'Dificuldade de acesso a alimentos saudáveis', 'Outros']
                        ]
                    ]
                ],
                [
                    'title' => 'Estilo de Vida',
                    'order' => 5,
                    'questions' => [
                        [
                            'text' => 'Você pratica atividades físicas regularmente?',
                            'type' => 'radio',
                            'order' => 1,
                            'options' => ['Sim', 'Não', 'Às vezes']
                        ]
                    ]
                ],
                [
                    'title' => 'Hábitos Alimentares',
                    'order' => 6,
                    'questions' => [
                        [
                            'text' => 'Como você descreveria sua alimentação atual?',
                            'type' => 'textarea',
                            'order' => 1,
                        ],
                        [
                            'text' => 'Você segue algum tipo de dieta específica?',
                            'type' => 'textarea',
                            'order' => 2,
                        ],
                        [
                            'text' => 'Você tem algum tipo de intolerância ou alergia alimentar?',
                            'type' => 'radio',
                            'order' => 3,
                            'options' => ['Sim', 'Não']
                        ],
                        [
                            'text' => 'Se sim, especifique:',
                            'type' => 'textarea',
                            'order' => 4,
                        ]
                    ]
                ]
            ];

            foreach ($sections as $sectionData) {
                Log::info('Creating section:', ['title' => $sectionData['title']]);

                $section = SurveySection::create([
                    'title' => $sectionData['title'],
                    'order' => $sectionData['order']
                ]);

                foreach ($sectionData['questions'] as $questionData) {
                    Log::info('Creating question:', ['text' => $questionData['text']]);

                    $question = SurveyQuestion::create([
                        'section_id' => $section->id,
                        'text' => $questionData['text'],
                        'type' => $questionData['type'],
                        'order' => $questionData['order'],
                        'required' => true
                    ]);

                    if (isset($questionData['options'])) {
                        foreach ($questionData['options'] as $index => $optionValue) {
                            Log::info('Creating option:', ['value' => $optionValue]);

                            SurveyQuestionOption::create([
                                'question_id' => $question->id,
                                'value' => $optionValue,
                                'order' => $index + 1
                            ]);
                        }
                    }
                }
            }

            Log::info('SurveySeeder completed successfully');
        } catch (\Exception $e) {
            Log::error('Error in SurveySeeder:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
