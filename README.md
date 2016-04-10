# DI

A bland name, I know, but a simple implementation of a dependency injection container that loads class definitions from a json file.

### Usage

Not very interesting either, just call `instantiate()` passing in the config file, then use fetch to pull in your classes.

The expected format of the JSON file is as follows:

```
{
  "objects": [
    {
      "name": "testObj",
      "class": "Person",
      "params": [
        { "type": "value", "value": "Damon" },
        { "type": "value", "value": 23 }
      ]
    },
    {
      "name": "greeter",
      "class": "Greeter",
      "params": [
        { "type": "ref", "value": "testObj" }
      ]
    },
    {
      "name": "testAutoload",
      "class": "Shruubi\\DI\\TestAutoloadedClass",
      "params": [
        { "type": "value", "value": 42 }
      ]
    }
  ]
}
```

You can have either `ref` params or `value` params, value params are just raw primitives passed into the class constructor, whereas a `ref` is a reference to a class that was instantiated via the container.
