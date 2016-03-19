CREATE USER 'gcpnext16'@'192.168.0.2' IDENTIFIED BY 'abacabbbabebibobu123';
GRANT DELETE ON gcpnext16lamp.* TO 'gcpnext16'@'';
GRANT INSERT ON gcpnext16lamp.* TO 'gcpnext16'@'%';
GRANT SELECT ON gcpnext16lamp.* TO 'gcpnext16'@'%';
GRANT UPDATE ON gcpnext16lamp.* TO 'gcpnext16'@'%';
FLUSH PRIVILEGES;
