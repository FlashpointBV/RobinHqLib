<?php
/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

namespace Emico\RobinHqLib\Queue\Serializer;


use Emico\RobinHqLib\Event\CustomerEvent;
use Emico\RobinHqLib\Event\EventInterface;
use Emico\RobinHqLib\Event\OrderEvent;
use Emico\RobinHqLib\Exception\SerializationException;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class EventSerializer
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    private $eventActionClassMapping = [
        'order' => OrderEvent::class,
        'customer' => CustomerEvent::class
    ];

    /**
     * EventSerializer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer = null)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param EventInterface $event
     * @return string
     */
    public function serializeEvent(EventInterface $event): string
    {
        return $this->getSymfonySerializer()->serialize($event, 'json', ['skip_null_values' => true]);
    }

    /**
     * @param string $event
     * @return EventInterface
     * @throws SerializationException
     */
    public function unserializeEvent(string $event): EventInterface
    {
        $jsonDecoder = new JsonDecode([JsonDecode::ASSOCIATIVE => true]);
        $json = $jsonDecoder->decode($event, 'json');
        //$json = $this->getSymfonySerializer()->deserialize($event, 'array', 'json');
        if (!isset($json['action'])) {
            throw new SerializationException('Expected event action in JSON message');
        }

        $action = $json['action'];
        if (!isset($this->eventActionClassMapping[$action])) {
            throw new SerializationException(sprintf('No event class implementation found for action "%s"', $action));
        }
        $eventClass = $this->eventActionClassMapping[$action];
        $eventInstance = $this->getSymfonySerializer()->deserialize(
            $event,
            $eventClass,
            'json'
        );

        if (!$eventInstance instanceof EventInterface) {
            throw new SerializationException('Deserialized data must be of type EventInterface');
        }

        return $eventInstance;
    }

    /**
     * @return SerializerInterface
     */
    protected function getSymfonySerializer(): SerializerInterface
    {
        if ($this->serializer === null) {
            $normalizer = new ObjectNormalizer(null, null, null, new ReflectionExtractor());
            $this->serializer = new Serializer(
                [new DateTimeNormalizer(), $normalizer],
                ['json' => new JsonEncoder()]
            );
        }
        return $this->serializer;
    }
}