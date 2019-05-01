<?php

namespace Communication;

use Model\Entity\User;

/**
 * Базовый класс Декоратора не содержит реальной логики
 * Его основная цель – реализовать базовую инфраструктуру
 * поле для хранения обёрнутого компонента или другого декоратора
 * и базовый метод отправки оповещений, который делегирует работу обёрнутому объекту.
 * Реальная работа по отправки оповещений выполняется подклассами.
 */
class BaseDecorator implements ICommunication
{
  /**
   * @var ICommunication
   */
  protected $communication;

  public function __construct(ICommunication $communication)
  {
    $this->communication = $communication;
  }

  /**
   * Декоратор делегирует всю работу обёрнутому компоненту.
   */
  public function send(User $user, string $title, string $message): void
  {
    $this->communication->send($user, $title, $message);
  }
}
