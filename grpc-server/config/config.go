package config

import (
	// "fmt"
	"io/ioutil"
	"log"

	yaml "gopkg.in/yaml.v2"
)

var cfg Config

type Config struct {
	Name string `yaml:"name"`
	Db   struct {
		Default Db `yaml:"default"`
	} `yaml:"db"`
}

type Db struct {
	Type     string `yaml:"type"`
	Host     string `yaml:"host"`
	Port     int    `yaml:"port"`
	User     string `yaml:"user"`
	Password string `yaml:"password"`
	Database string `yaml:"database"`
}

func Get() *Config {
	return &cfg
}

func Setup() {
	content, err := ioutil.ReadFile("config.yaml")
	if err != nil {
		log.Fatalf("error: %v", err)
	}

	err = yaml.Unmarshal(content, &cfg)
	if err != nil {
		log.Fatalf("error: %v", err)
	}
}
