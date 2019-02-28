<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateController extends Command
{
    protected $commandName = 'app:controller';
    protected $commandDescription = "Greets Someone";

    protected $commandArgumentName = "name";
    protected $commandArgumentDescription = "Who do you want to greet?";

    protected $commandOptionName = "cap";
    protected $commandOptionDescription = 'If set, it will greet in uppercase letters';    

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commandArgumentName,
                InputArgument::OPTIONAL,
                $this->commandArgumentDescription
            )
            ->addOption(
               $this->commandOptionName,
               null,
               InputOption::VALUE_NONE,
               $this->commandOptionDescription
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument($this->commandArgumentName);

        $content = file_get_contents("Commands/files/Controller.php");
        $content = str_replace("class Controller", "class $name", $content);

		$file = fopen("app/controllers/$name.php", "w+");
		$result = fwrite($file, $content);
		fclose($file);

        if ($result) {
            $text = "Created $name";
        } else {
            $text = "Error";
        }

        if ($input->getOption($this->commandOptionName)) {
            $text = strtoupper($text);
        }

        $output->writeln($text);
    }
}