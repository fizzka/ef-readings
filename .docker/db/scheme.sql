CREATE TABLE readings (
    sensor_uuid UUID NOT NULL,
    temperature SMALLINT NOT NULL,
    created TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE INDEX sensor_idx ON readings (sensor_uuid);

CREATE VIEW readings_average (sensor_uuid, temperature) AS
SELECT sensor_uuid, AVG(temperature)::SMALLINT
FROM readings
WHERE created > NOW() - '1 HOUR'::INTERVAL
GROUP BY sensor_uuid;
