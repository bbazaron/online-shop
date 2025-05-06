<?php

namespace Model;

class Logs extends \Model\Model
{
    protected static function getTableName(): string
    {
        return 'logs';
    }
    public static function insert(\Throwable $exception, int $userId, int $sum)
    {
        $tableName = static::getTableName();

        $logData = [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'context' => ['user_id' => $userId, 'order_sum' => $sum]
        ];

        $stmt = static::getPDO()->prepare("
                                    INSERT INTO $tableName (message, file, line, created_at, context)
                                    VALUES (:message, :file, :line, :created_at, :context)
                                    ");

        $stmt->execute([
            ':message' => $logData['message'],
            ':file' => $logData['file'],
            ':line' => $logData['line'],
            ':created_at' => date('Y-m-d H:i:s'),
            ':context' => json_encode($logData['context']) //json для записи массива в бд
        ]);
    }
}